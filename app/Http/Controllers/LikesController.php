<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;

class LikesController extends Controller
{
    public function addArticleLike(Request $request)
    {
		Like::create($request->all());
		return redirect()->back();
	}
}
