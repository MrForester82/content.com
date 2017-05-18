@extends('layouts.app')

@section('content')

<script>
   function displayForm($id)
   {
		document.getElementById($id).style.display='block';
   }
</script>

<?php
	if(!Auth::guest())	
		$isbanned = DB::table('bans')->select('id')->where('id_user', Auth::user()->id)->first();
	if(isset($isbanned))
		return redirect('/home');
?>

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2 class="text-center">{{ $article->title }}</h2>
    <p class="lead">{!! $article->text !!}</p>
    <h4 class="text-right"> {{ $article->adding_date }} </h4>
    <h4 class="text-right"> {{ $author->name }} </h4>
  </div>
</div>

@if(!Auth::guest())
<div class="container">
	<div class="row">

			{!! Form::open(['route'=>'addComment', 'name'=>'dislikeArticleForm', 'method'=>'POST', 'class'=>'navbar-form navbar-right']) !!}
				  <input type="hidden" name="id_article" id="id_article" value= {{ $article->id }}>
				  <input type="hidden" name="value" id="value" value="0">
				  <input type="hidden" name="id_user" id="id_user" value="{{ Auth::user()->id }}">
				  <input type="hidden" name="type" id="type" value="article">
				  <button type="submit" class="btn btn-danger">
				  	<span class="glyphicon glyphicon-heart"></span>
				  </button>
			  {{csrf_field()}}
			{!! Form::close() !!}
			<div class="navbar-form navbar-right">
				<h4 class="likes-vert-allignment-d">{{ $dislikes }}</h4>
			</div>

			{!! Form::open(['route'=>'addComment', 'name'=>'likeArticleForm', 'method'=>'POST', 'class'=>'navbar-form navbar-right']) !!}
				  <input type="hidden" name="id_article" id="id_article" value= {{ $article->id }}>
				  <input type="hidden" name="value" id="value" value="1">
				  <input type="hidden" name="id_user" id="id_user" value="{{ Auth::user()->id }}">
				  <input type="hidden" name="type" id="type" value="article">
				  <button type="submit" class="btn btn-success">
				  	<span class="glyphicon glyphicon-heart"></span>
				  </button>
			  {{csrf_field()}}
			{!! Form::close() !!}
			<div class="navbar-form navbar-right">
				<h4 class="likes-vert-allignment-d">{{ $likes }}</h4>
			</div>
			
	</div>
		

</div> <!-- /container --> 
@endif

<div class="container">
	<div class="form">
	
		<div id="wrapper">
			<div id="comments">
				<div id="form-comment">
					@if(!Auth::guest())
		    		<form method="POST" action="{{ route('addComment') }}">
					    <div class="form-group">
					    	<label for="message">Ваш комментарий</label>
					    	<textarea name="message" id="message" class="form-control"></textarea><br>
					    </div>
					    <input type="hidden" name="parent_id" id="parent_id" value="0">
					    <input type="hidden" name="author" id="author" value="{{ Auth::user()->name }}">
					    <input type="hidden" name="email" id="email" value="{{ Auth::user()->email }}">
					    <input type="hidden" name="id_article" id="ia_article" value="{{ $article->id }}">
					    <button type="btn btn-default">Отправить</button>
					    {{csrf_field()}}
					</form>
					@endif
				</div>    
				<hr style="height: 2px; background-color:#555; margin-top: 20px; margin-bottom: 20px; width: 90%;">
				@foreach($tree as $comment)
					<div class="comment">
						<div class="row">
							<div class="row">
								<div class="pull-left col-xs-2">
									<h4>{{$comment->author}}</h4>
								</div>
								<div class="col-xs-3">
									<h5>{{$comment->created_at}}</h5>
								</div>
								@if(!Auth::guest())
								<div class="col-xs-2">
									<button type="submit" class="btn btn-info" OnClick="displayForm({{ $comment->id }})">
				  						<span class="glyphicon glyphicon-envelope"></span>
				  					</button>
									
								</div>
								
									{!! Form::open(['route'=>'addComment', 'name'=>'dislikeCommentForm', 'method'=>'POST', 'class'=>'navbar-form navbar-right']) !!}
										<input type="hidden" name="id_comment" id="id_comment" value= "{{ $comment->id }}">
										<input type="hidden" name="value" id="value" value="0">
										<input type="hidden" name="id_user" id="id_user" value="{{ Auth::user()->id }}">
										<input type="hidden" name="type" id="type" value="comment">
										<button type="submit" class="btn btn-danger">
										  <span class="glyphicon glyphicon-heart"></span>
										</button>
										{{csrf_field()}}
									{!! Form::close() !!}
									<div class="navbar-form navbar-right">
										<?php
											$com_dislikes = DB::table('com_likes')
												->select('id')
												->where('value', 0)
												->where('id_comment', $comment->id)
												->groupBy('id_comment')
												->count();
												
											echo "<h4 class=\"likes-vert-allignment-d\">".$com_dislikes."</h4>";
										?>
									</div>

									{!! Form::open(['route'=>'addComment', 'name'=>'likeCommentForm', 'method'=>'POST', 'class'=>'navbar-form navbar-right']) !!}
										<input type="hidden" name="id_comment" id="id_comment" value= "{{ $comment->id }}">
										<input type="hidden" name="value" id="value" value="1">
										<input type="hidden" name="id_user" id="id_user" value="{{ Auth::user()->id }}">
										<input type="hidden" name="type" id="type" value="comment">
										<button type="submit" class="btn btn-success">
										  <span class="glyphicon glyphicon-heart"></span>
										</button>
										{{csrf_field()}}
									{!! Form::close() !!}
									<div class="navbar-form navbar-right">
										<?php

											$com_likes = DB::table('com_likes')
												->select('id')
												->where('value', 1)
												->where('id_comment', $comment->id)
												->groupBy('id_comment')
												->count();
												
											echo "<h4 class=\"likes-vert-allignment-d\">".$com_likes."</h4>";
											
										?>
									</div>
								
								@endif
							</div>
							<div>
								<p>{{$comment->message}}</p>
							</div>
							@if(!Auth::guest())
							<div id="{{ $comment->id }}" class="container" style="display: none;">
								<div class="form">
									<form method="POST" action="{{ route('addComment') }}">
										<div class="form-group">
							    			<label for="message">Ваш комментарий</label>
							    			<textarea name="message" id="message" class="form-control"></textarea><br>
							    		</div>
							    		<input type="hidden" name="parent_id" id="parent_id" value="{{$comment->id}}">
							    		<input type="hidden" name="author" id="author" value="{{ Auth::user()->name }}">
							    		<input type="hidden" name="email" id="email" value="{{ Auth::user()->email }}">
							    		<input type="hidden" name="id_article" id="ia_article" value="{{ $article->id }}">
							    		<button type="submit" class="btn btn-primary">
				  							<span class="glyphicon glyphicon-envelope"></span>
				  						</button>
							    		
							    		{{csrf_field()}}
									</form>
								</div>
							</div>
							@endif
							
							<!--<a id="{{$comment->id}}" href="#">Ответить</a>-->
						</div>

						@if(isset($comment->childs))
							@include('rotator',['tree'=>$comment->childs])
						@endif
					</div>
				@endforeach
			</div>
		</div>
		
	</div>
</div> 

<script>

	var comments=document.getElementById('comments'); //выбираем весь блок div с id=comments
	var ref=comments.getElementsByTagName('a'); //выбираем все ссылки внутри блока comments
	var form=document.getElementById('form-comment'); //выбираем форму для комментирования
	for( i=0; i<ref.length; i++)
	{
		ref[i].addEventListener('click',answer); //проходимся циклом по колекции ссылок и на каждую вешаем обработчик
	}
	
	function showRef()
	{ // функция показывает все ссылки "Ответить"
		for( i=0; i<ref.length; i++)
		{
			ref[i].style.display="inline-block"; //проходимся циклом по колекции ссылок и делаем их видимыми
		}
	}
		
	function cancel()
	{ // функция обрабатывает нажание на ссылку "Отменить ответ"
		this.parentNode.removeChild(this); //удаляем ссылку на отмену комментария
		form.parentNode.removeChild(form); //удаляем форму
		comments.appendChild(form); //добавляем форму в конце списка комментариев
		showRef(); //показываем все ссылки "ответить"
		document.getElementById('parent_id').value=0; // обнуляем значение скрытого поля parent_id
	}
	
	function answer()
	{
		showRef(); //показываем все ссылки "ответить"
		var parent_id=this.id; //получаем id родительсокго комментария
		this.style.display="none"; //скрываем ссылку "ответить"
		document.getElementById('parent_id').value=parent_id; //в скрытое поле помещаем значение id родительского комменатрия.
		form.parentNode.removeChild(form); // удаляем форму, что бы отобразить ее возле родительского комменатрия
		this.parentNode.appendChild(form); //отображаем форму внутри родительского комментария
		var cancel_answer=document.createElement('a'); //создаем ссылку для отмены ответа
		cancel_answer.href='#'; //сслыка ни на что не ссылается
		cancel_answer.style.color="red"; //задаем цвет ссылки
		cancel_answer.id="cancel_anwer"; //назначаем id для ссылки, что легче потом отбирать
		cancel_answer.appendChild(document.createTextNode('Отменить ответ')); //добавляем текст для ссылки
		this.parentNode.appendChild(cancel_answer); //и добавляем ссылки в конце формы
		cancel_answer.addEventListener('click',cancel); // вешаем обработчик  что бы отменить ответ
	}
	
</script>

@endsection