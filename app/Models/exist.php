<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class exist extends Model
{

    public $table = 'exist';
    public $timestamps = false;
    protected $fillable = ['id', 'exist', 'user'];
}
