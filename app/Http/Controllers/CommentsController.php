<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\User;
use App\Comment;

class CommentsController extends Controller
{
	public function index($id)
	{
    	$article = Article::select('id', 'title', 'text', 'adding_date', 'id_user')->where('id', $id)->first();
		$author = User::select('name')->where('id', $article['id_user'])->first();
		
		/*
		return view('article-content')->with([	'article'=>$article,
												'author'=>$author,
											]);
		*/
		$comments=Comment::all(); //Выбрали все записи из таблицы comments
		
		
		return view('article-content',['tree'=>$this->makeArray($comments)])->with([	'article'=>$article,
																						'author'=>$author,
																					]);									
	}
    
    
	public function addComment(Request $request)
	{
		$this->validate($request, [
			//'author' => 'required|max:255',
			//'email' => 'required',
			'message' => 'required'
		]);
		
		Comment::create($request->all());
		return redirect()->back();
	}
	
	
	private function makeArray($comments){
		$childs=[];
		
		foreach($comments as $comment){
			$childs[$comment->parent_id][]=$comment;
		}
		
		foreach($comments as $comment){
			if(isset($childs[$comment->id]))
				$comment->childs=$childs[$comment->id];
			
		}
		if(count($childs)>0){
			$tree=$childs[0];
			}
		else {
				$tree=[];
			}
		return $tree;
	}
}
