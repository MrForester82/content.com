<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable=['parent_id','author','email','message'];
    protected $table="comments";
}
