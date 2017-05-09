<script>
   function displayForm($id)
   {
		document.getElementById($id).style.display='block';
   }
</script>

@foreach($tree as $comment)
	<div style="margin-left: 20px;" class="comment child">
		<div class="row">
			<div class="pull-left col-xs-2">
				<h4>{{$comment->author}}</h4>
			</div>
			<div class="col-xs-3">
				<h4>{{$comment->created_at}}</h4>
			</div>
			@if(!Auth::guest())
			<div class="col-xs-2">
				<button type="btn btn-default" OnClick="displayForm({{ $comment->id }})">Ответить</button>
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
		    		<button type="btn btn-default">Ответить</button>
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