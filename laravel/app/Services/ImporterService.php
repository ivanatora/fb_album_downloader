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
    protected $accessToken = 'EAACEdEose0cBAIQxG6Mp3UE4pFEYVhUf2SiAGZBxXsIyGaUN5TeO74V3DHImUnBUfPDu00uhB4abWkvfU1V3SBIlCkL2Jx6gmKmo91PDeZBngQfsoKHIPLDZBK9VEXuwrxmUpGVRpFBZCvlyv3yZAW6lKUiHF7yM10Lj5D9Qejv8yLjKN0Hk9z0D7nODI26wZD';

    public function import()
    {
        DB::table('comments')->delete();
        DB::table('photos')->delete();
        DB::table('albums')->delete();


        print "\n\nAll done\n";
    }


}