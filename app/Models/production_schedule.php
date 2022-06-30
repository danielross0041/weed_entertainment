<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class production_schedule extends Model
{
    protected $primaryKey = 'id';
  	protected $table = 'production_schedule';
    protected $guarded = [];

    public function time()
    {
        return $this->hasMany(production_schedule_time::class, 'production_schedule_id');
    }
}