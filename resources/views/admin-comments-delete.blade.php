@extends('layouts.app')

@section('content')
<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h1 class="text-center">Раздел комментариев ADMIN</h1>
  </div>
</div>


<div class="container">
  
  @foreach($comments as $comment)
  	<div class="well">
  		{!! Form::open(['route'=>'admin.delete.comment', 'method'=>'POST', 'class'=>'navbar-form navbar-right', 'role'=>'delComment']) !!}
  			<input type="hidden" name="id_comment" id="id_comment" value= "{{ $comment->id }}">
	  		<div class="input-group">
			  	<span class="input-group-btn">
			  		<button type="submit" class="btn btn-danger">
			  			<span class="glyphicon glyphicon-trash"></span>
			  		</button>
			  	</span>
		  	</div>
		  {{csrf_field()}}
		{!! Form::close() !!}
		
      	<div class="col-md-2">
      		<h4> {{ $comment->author }} </h4>
      	</div>
      	<div class="col-md-2">
      		<h4> {{ $comment->created_at }} </h4>
      	</div>
    		<h4> {{ $comment->message }} </h4>
   	</div>
  @endforeach
  
</div> <!-- /container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="jquery.min.js"><\/script>')</script>
<script src="bootstrap.min.js"></script>
@endsection