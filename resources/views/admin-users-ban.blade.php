@extends('layouts.app')

@section('content')
<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h1 class="text-center">Раздел пользователей ADMIN</h1>
  </div>
</div>


<div class="container">
  
  @foreach($users as $user)
  	<div class="well">
  		{!! Form::open(['route'=>'admin.ban.user', 'method'=>'POST', 'class'=>'navbar-form navbar-right', 'role'=>'banUser']) !!}
  			<input type="hidden" name="id_user" id="id_user" value= "{{ $user->id }}">
	  		<div class="input-group">
			  	<span class="input-group-btn">
			  	<?php
			  		$inban = DB::table('bans')->select('id')->where('id_user', $user->id)->first();
			  		
			  		if(isset($inban))
			  			echo "<button type=\"submit\" class=\"btn btn-danger\" disabled>";
			  		else
			  			echo "<button type=\"submit\" class=\"btn btn-danger\">";
			  			
			  			//<button type="submit" class="btn btn-danger">
			  	?>
			  		
			  			<span class="glyphicon glyphicon-remove-circle"></span>
			  		</button>
			  	</span>
		  	</div>
		  {{csrf_field()}}
		{!! Form::close() !!}
		
      	<div class="col-md-2">
      		<h4> {{ $user->name }} </h4>
      	</div>
      	
      	<h4> {{ $user->email }} </h4>
      	
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