<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class comments extends Model
{
 	protected $primaryKey = 'id';
  	protected $table = 'comments';
    protected $guarded = [];

    public function replies()
    {
        return $this->hasMany(replies::class, 'comment_id');
    }  
}
