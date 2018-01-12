<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Services\ImporterService;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    /**
     * @var ImporterService
     */
    protected $importer;

    public function construct(ImporterService $importer)
    {
        $this->importer = $importer;

        parent::__construct();
    }

    public function test()
    {
        $baseUrl = 'https://graph.facebook.com/v2.11/';
        $groupId = '178560628279';
        //'https://graph.facebook.com/v2.11/178560628279/albums?access_token=EAACEdEose0cBAIQxG6Mp3UE4pFEYVhUf2SiAGZBxXsIyGaUN5TeO74V3DHImUnBUfPDu00uhB4abWkvfU1V3SBIlCkL2Jx6gmKmo91PDeZBngQfsoKHIPLDZBK9VEXuwrxmUpGVRpFBZCvlyv3yZAW6lKUiHF7yM10Lj5D9Qejv8yLjKN0Hk9z0D7nODI26wZD&pretty=0&limit=25&after=MTAxNTMwNjA4MDM1NzMyODAZD';
        $accessToken = 'EAACEdEose0cBAIQxG6Mp3UE4pFEYVhUf2SiAGZBxXsIyGaUN5TeO74V3DHImUnBUfPDu00uhB4abWkvfU1V3SBIlCkL2Jx6gmKmo91PDeZBngQfsoKHIPLDZBK9VEXuwrxmUpGVRpFBZCvlyv3yZAW6lKUiHF7yM10Lj5D9Qejv8yLjKN0Hk9z0D7nODI26wZD';

        $url = $baseUrl . $groupId . '/albums?access_token=' . $accessToken;
        $content = file_get_contents($url);
        $data = json_decode($content, true);
        print "<pre>";
        print_r($data);
//        while (isset($data[]))
    }
}