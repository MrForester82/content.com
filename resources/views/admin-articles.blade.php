@extends('layouts.app')

@section('content')
<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h1 class="text-center">Раздел статей ADMIN</h1>
  </div>
</div>


<div class="container">
  
  @foreach($articles as $article)
  	<div class="well">
  		<div class="navbar-form navbar-right">
	  		<a class="btn btn-warning" href=" {{ route('edit.article', ['id' => $article->id]) }}" role="button">
	      		<span class="glyphicon glyphicon-pencil"></span>
	      	</a>
      	</div>
    	<h3> {{ $article->title }} </h3>
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