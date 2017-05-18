<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Article;
use App\Comment;
use App\User;
use App\Ban;

class AdminCommandController extends Controller
{
    public function showArticleList()
	{
		if(Auth::guest())
			return redirect('/');
		else
			$isuser = User::select('id')->where('id', Auth::user()->id)->first();
		
		if(isset($isuser))
		{
			return redirect('/');
		}
		
		$articles = Article::select('id', 'title')
							->orderBy('adding_date')->get();
		
		return view('admin-articles')->with([ 'articles'=>$articles ]);
	}
	
	public function editArticle($id)
	{
		if(Auth::guest())
			return redirect('/');
		else
			$isuser = User::select('id')->where('id', Auth::user()->id)->first();
		
		if(isset($isuser))
		{
			return redirect('/');
		}
		
		$article = Article::select('id', 'title', 'description', 'text', 'id_partition')
							->where('id', $id)
							->first();
						
		return view('admin-edit-article')->with([ 'article'=>$article ]);
	}
	
	public function saveArticle(Request $request)
	{
		$this->validate($request, [
			'title' => 'required|max:255',
			'description' => 'required',
			'text' => 'required'
		]);
		
		DB::update('update articles
					set title = ?,
					description = ?,
					text = ?,
					id_partition = ?
					where id = ?',
					[$request['title'],
					$request['description'],
					$request['text'],
					$request['partition'],
					$request['id_article']]);
					
		return redirect('admin/article/list');
	}
	
	public function showComments()
	{
		if(Auth::guest())
			return redirect('/');
		else
			$isuser = User::select('id')->where('id', Auth::user()->id)->first();
		
		if(isset($isuser))
		{
			return redirect('/');
		}
		
		$comments=Comment::select('id', 'author', 'message', 'created_at')->get();
		
		return view('admin-comments-delete')->with([ 'comments'=>$comments ]);
	}
	
	public function delComment(Request $request)
	{
		DB::table('comments')
			->where('id', $request['id_comment'])
			->delete();
			
		return redirect('admin/comments');
	}
	
	public function showUsers()
	{
		if(Auth::guest())
			return redirect('/');
		else
			$isuser = User::select('id')->where('id', Auth::user()->id)->first();
		
		if(isset($isuser))
		{
			return redirect('/');
		}
		
		$users=User::select('id', 'name', 'email')->get();
		
		return view('admin-users-ban')->with([ 'users'=>$users ]);
	}
	
	public function banUser(Request $request)
	{
		Ban::insert(['id_user'=>$request['id_user'], 'id_admin'=>1]);
		
		return redirect('admin/users');
	}
}
