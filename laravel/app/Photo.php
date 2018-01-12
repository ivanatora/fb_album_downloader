<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Photo extends Model
{
    protected $table = 'photos';
    public $timestamps = false;

    public function comments()
    {
        return $this->hasMany('App\Comment', 'photo_id');
    }

}