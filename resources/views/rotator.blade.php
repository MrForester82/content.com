
@foreach($tree as $comment)
	<div style="margin-left: 20px;" class="comment child">
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
		
		@if(isset($comment->childs))
			@include('rotator',['tree'=>$comment->childs])
		@endif
	</div>
@endforeach