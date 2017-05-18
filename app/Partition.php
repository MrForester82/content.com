<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partition extends Model
{
    protected $fillable = ['partition'];
    protected $table = 'partitions';
}
