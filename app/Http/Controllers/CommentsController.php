<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Cookie;
use App\Article;
use App\User;
use App\Comment;
use App\Like;

class CommentsController extends Controller
{
	public function index($id)
	{
    	$article = Article::select('id', 'title', 'text', 'adding_date', 'id_user')->where('id', $id)->first();
		$author = User::select('name')->where('id', $article['id_user'])->first();

		$comments=Comment::select('id', 'parent_id', 'author', 'id_article', 'message', 'email', 'created_at', 'updated_at')
							->where('id_article', $id)
							->get();
		/*					
		$comments = DB::select('SELECT comments.id, parent_id, author, id_article, message, email, created_at, L.likes, D.dislikes
								FROM 	comments, 
										(SELECT id_comment, COUNT(com_likes.id) AS likes
										FROM com_likes
										WHERE value = 1
										GROUP BY id_comment
										HAVING id_comment = comments.id) L,						//comments.id не найдено
										(SELECT id_comment, COUNT(com_likes.id) AS dislikes
										FROM com_likes
										WHERE value = 0
										GROUP BY id_comment
										HAVING id_comment = comments.id) D
								WHERE id_article=?', [$id]);	
		*/						

		$likes = Like::select('id')
			->where('id_article', $id)
			->where('value', 1)
			->count();
			
		$dislikes = Like::select('id')
			->where('id_article', $id)
			->where('value', 0)
			->count();

		return view('article-content',['tree'=>$this->makeArray($comments)])->with([	'article'=>$article,
																						'author'=>$author,
																						'likes'=>$likes,
																						'dislikes'=>$dislikes,
																						//'com_likes'=>$com_likes,
																						//'com_dislikes'=>$com_dislikes
																					]);									
	}
    /*
    public function setCookie($id_user)
    {
      	$response = new Response($id_user);
      	$response->withCookie(cookie()->forever($id_user, $id_user) );
      	return $response;
   	}
    */
    private function addLike(Request $request)
    {
		if($request['type'] == 'article')
		{
			$like = Like::select('id', 'id_user', 'value')->where('id_user', $request['id_user'])->first();
			if(!($like))
			{
				Like::insert([	'id_article'=>$request['id_article'],
								'value'=>$request['value'],
								'id_user'=>$request['id_user']
						]);
				//$cookie = Cookie::forever('like_form_user_'.$request['id_user'], $request['id_user']);	//forever - 5 лет
				//setCookie($request['id_user']);
			}
			if($like['value'] != $request['value'] && $request['value'] == 0)
			{
				DB::update('update art_likes set value = ? where id_user = ?', [0, $request['id_user']]);
			}
			if($like['value'] != $request['value'] && $request['value'] == 1)
			{
				DB::update('update art_likes set value = ? where id_user = ?', [1, $request['id_user']]);
			}
		}
		
		if($request['type'] == 'comment')
		{	
			$like_com = DB::select('select id, id_user, value, id_comment from com_likes where id_user=? and id_comment=?', [$request['id_user'], $request['id_comment']]);			
			
			if(!($like_com))
			{
				DB::table('com_likes')->insert([	'id_comment'=>$request['id_comment'],
													'value'=>$request['value'],
													'id_user'=>$request['id_user']
						]);
				//$cookie = Cookie::forever('like_form_user_'.$request['id_user'], $request['id_user']);	//forever - 5 лет
				//setCookie($request['id_user']);
			}
			else
			{
				$like_c = $like_com['0'];
				if($like_c->value != $request['value'] && $request['value'] == 0)
				{
					DB::update('update com_likes set value = ? where id_user = ? and id_comment = ?', [0, $request['id_user'], $request['id_comment']]);
				}
				if($like_c->value != $request['value'] && $request['value'] == 1)
				{
					DB::update('update com_likes set value = ? where id_user = ? and id_comment = ?', [1, $request['id_user'], $request['id_comment']]);
				}
			}
			
		}
	}
    
	public function addComment(Request $request)
	{
		if(isset($request['value']))
		{
			$this->addLike($request);
		}
		else
		{
			$this->validate($request, [
			//'author' => 'required|max:255',
			//'email' => 'required',
			'message' => 'required'
			]);
			
			Comment::create($request->all());
		}
		
		return redirect()->back();
	}
	
	private function makeArray($comments)
	{
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
