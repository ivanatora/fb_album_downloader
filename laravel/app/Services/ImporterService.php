<?php

namespace App\Services;

use DB;
use XmlParser;
use App\Album;
use App\Photo;
use App\Comment;

class ImporterService
{
    protected $baseUrl = 'https://graph.facebook.com/v2.11/';
    protected $groupId = '178560628279';
    protected $accessToken = 'EAACEdEose0cBAP0UO9uolw9qJgTzYZCmytNLHGoOI6upOeskZBGjxQihGykkZBZCduZBZBOs9bgZAZAhR7pcvMVL3V0XvwAnfLfYT9NXBwGpmpf5p6xbPRpmIrZBvRSb2lADnu9DdVZBrcHPy5xiRNkbMHjzGKXt7wHLNxjvPmv8Rw6G48vE4DZBqK3KQdH97UkvTIZD';

    public function import()
    {
        DB::table('comments')->delete();
        DB::table('photos')->delete();
        DB::table('albums')->delete();

//        $this->processAlbum(10153357332673280);
//        exit();

        $url = $this->baseUrl . $this->groupId . '/albums?access_token=' . $this->accessToken . '&limit=100';

        $content = file_get_contents($url);
        $data = json_decode($content, true);
        $this->processAlbumPage($data);

        print "\n\nAll done\n";
    }

    protected function processAlbumPage($data)
    {
        foreach ($data['data'] as $item) {
            $this->processAlbum($item['id']);
        }

        if (isset($data['paging']) && isset($data['paging']['next'])) {
            $content = file_get_contents($data['paging']['next']);
            $data = json_decode($content, true);
            $this->processAlbumPage($data);
        }
    }

    protected function processAlbum($id)
    {
        print "Processing album $id\n";
        $url = $this->baseUrl . $id . '?fields=name,count,id,link,from,comments,created_time,description,photos{created_time,comments,picture,name}&limit=100&access_token=' . $this->accessToken;

        $content = file_get_contents($url);
        $data = json_decode($content, true);

        $album = new Album();
        $album->fb_id = $id;
        $album->name = $data['name'];
        $album->link = $data['link'];
        $album->author_name = $data['from']['name'];
        $album->author_id = $data['from']['id'];
        $album->created_time = date('Y-m-d H:i:s', strtotime($data['created_time']));
        $album->description = isset($data['description']) ? $data['description'] : '';
        $album->save();

        $dir = app_path() . '/../storage/albums/' . $id;
        @mkdir($dir, 077, true);

        if (isset($data['comments']['data'])) {
            foreach ($data['comments']['data'] as $item) {
                $comment = new Comment();
                $comment->album_id = $album->id;
                $comment->created_time = date('Y-m-d H:i:s', strtotime($item['created_time']));
                $comment->poster_name = $item['from']['name'];
                $comment->poster_id = $item['from']['id'];
                $comment->message = $item['message'];
                $comment->save();
            }
        }

        foreach ($data['photos']['data'] as $item) {
            $photo = new Photo();
            $photo->album_id = $album->id;
            $photo->picture_url = $item['picture'];
            $photo->picture_id = $item['id'];
            $photo->created_time = date('Y-m-d H:i:s', strtotime($item['created_time']));
            $photo->name = isset($item['name']) ? $item['name'] : '';
            $photo->save();

            $photo_url = $this->baseUrl . $item['id'] . '/picture?access_token=' . $this->accessToken;
//            copy($photo_url, $dir . '/' . $item['id'] . '.jpg');

            if (isset($item['comments'])) {
                foreach ($item['comments']['data'] as $item_comment) {
                    $comment = new Comment();
                    $comment->photo_id = $photo->id;
                    $comment->created_time = date('Y-m-d H:i:s', strtotime($item_comment['created_time']));
                    $comment->poster_name = $item_comment['from']['name'];
                    $comment->poster_id = $item_comment['from']['id'];
                    $comment->message = $item_comment['message'];
                    $comment->save();
                }
            }
        }
    }
}