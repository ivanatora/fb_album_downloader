<?php

namespace App\Services;

use DB;
use XmlParser;

class ImporterService
{
    protected $groupId = '';
    protected $accessToken = '';

    public function import()
    {
        DB::table('categories')->delete();


        print "\n\nAll done\n";
    }


}