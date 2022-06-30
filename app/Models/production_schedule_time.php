<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class production_schedule_time extends Model
{
    protected $primaryKey = 'id';
  	protected $table = 'production_schedule_time';
    protected $guarded = [];
}