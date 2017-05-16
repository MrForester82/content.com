<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
	protected $fillable=['id_article', 'value', 'id_user'];
    protected $table="art_likes";
}
