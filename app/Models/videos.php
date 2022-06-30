<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class videos extends Model
{
 	protected $primaryKey = 'id';
  	protected $table = 'videos';
    protected $guarded = [];

    public function comments()
    {
        return $this->hasMany(comments::class, 'video_id');
    }  
}
