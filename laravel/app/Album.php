<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Album extends Model
{
    protected $table = 'albums';
    public $timestamps = false;

    public function photos()
    {
        return $this->hasMany('App\Photo', 'album_id');
    }

}