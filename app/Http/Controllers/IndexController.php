<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Article;
use App\User;
use App\Comment;
use App\Partition;
use Auth;

class IndexController extends Controller
{
	
	protected function getUserIdByName($name)
	{
		$id = User::select('id')->where('name', $name)->first();
		return $id['id'];
	}
	
    public function index(Request $request)
    {
    	if(!Auth::guest())	
    		$isbanned = DB::table('bans')->select('id')->where('id_user', Auth::user()->id)->first();
    	if(isset($isbanned))
		{
			return redirect('/home');
		}
    	
    	if($term = $request['term'])
    	{
    		$id = $this->getUserIdByName($term);
    		
			$articles = Article::select('id', 'title', 'description', 'id_user')
								->where('title', 'like', '%'.$term.'%')
								->orWhere(strval('id_user'), $id)
								->orderBy('adding_date')
								->paginate(5);
		}
		
		if(isset($request->partition))
		{
			$id_partition = Partition::select('id')->where('partition', $request->partition)->first();
			//dump($id_partition->id);
			$articles = Article::select('id', 'title', 'description')
								->where('id_partition', $id_partition->id)
    							->orderBy('adding_date')->get();
		}
		
    	if(!isset($articles))
    	{
    		$articles = Article::select('id', 'title', 'description')
    							->orderBy('adding_date')
    							->paginate(5);
    	}   
    	
		return view('articles')->with([	'articles'=>$articles
										//'partitions'=>$part
									]);
	}
	
	public function showArticle($id)
	{
		$article = Article::select('id', 'title', 'text', 'adding_date', 'id_user')->where('id', $id)->first();
		$author = User::select('name')->where('id', $article['id_user'])->first();
		//$comment = Comment::select('id', 'text', 'id_user', 'date')->where('id_article', $id)->get();
		//$authors = User::select('name, id_user')->where('id', $comment['id_user'])->get();
		
		$comment = DB::table('comments')
        	->join('users', 'users.id', '=', 'comments.id_user')
        	->select('comments.text', 'comments.date', 'users.name')
        	->where('comments.id_article', $id)
        	->get();
		//dump($comment);
		
		return view('article-content')->with([	'article'=>$article,
												'author'=>$author,
												'comments'=>$comment,
												'likes'=>$likes]);
	}
	
	public function add()
    {
    	if(!Auth::guest())	
    		$isbanned = DB::table('bans')->select('id')->where('id_user', Auth::user()->id)->first();
    	if(isset($isbanned))
			return redirect('/home');

		return view('add-article');
	}
	
	public function store(Request $request)
    {
		$this->validate($request, [
			'title' => 'required|max:255',
			'description' => 'required',
			'text' => 'required'
		]);
		
		$data = $request->all();
		$article = new Article;
		$article->fill($data);
		
		$id_partition = Partition::select('id')->where('partition', $request->partition)->first();
		//$article->save();
		DB::table('articles')->insert([
			'title' => $article['title'],
			'text' => $article['text'],
			'description' => $article['description'],
			'id_user' => $article['id_user'],
			'id_partition' => $id_partition->id
		]);
		return redirect('article/list');
	}
	
	public function saveComment(Request $request)
	{
		$this->validate($request, [
			'text' => 'required'
		]);
		
		$data = $request->all();
		$comment = new Comment;
		$comment->fill($data);
		DB::table('comments')->insert([
			'text' => $comment['text'],
			'id_user' => $comment['id_user'],
			'id_article' => $comment['id_article']
		]);
		//dump($id);
		return redirect('article/'.$comment['id_article']);
	}
}
