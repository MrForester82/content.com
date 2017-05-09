<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable=['parent_id','author','email','message', 'id_article'];
    protected $table="comments";
}
