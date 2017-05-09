@extends('layouts.app')

@section('content')
<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h1 class="text-center">Раздел статей</h1>
  </div>
</div>

<div class="container">
	{!! Form::open(['route'=>'article.list', 'method'=>'GET', 'class'=>'navbar-form navbar-right', 'role'=>'search']) !!}
	<!--<form action="GET" class="navbar-form navbar-right" role="search">-->
	  <div class="input-group">
	  	{!! Form::text('term', '', ['class'=>'form-control', 'placeholder'=>'Поиск...']) !!}
	  	<!--<input type="text" name="term" id="term" class="form-control" placeholder="Поиск...">-->
	  	<span class="input-group-btn">
	  		<button type="submit" class="btn btn-default">
	  			<span class="glyphicon glyphicon-search"></span>
	  		</button>
	  	</span>
	  </div>
	  {{csrf_field()}}
	<!--</form>-->
	{!! Form::close() !!}
</div> <!-- /container -->

<div class="container">
  
  @foreach($articles as $article)
  	<div class="row">
      <h2> {{ $article->title }} </h2>
      <p class="text-justify"> {{ $article->description }} </p>
      <p><a class="btn btn-default" href=" {{ route('showArticle', ['id' => $article->id]) }}" role="button">Подробнее &raquo;</a></p>
   	</div>
  @endforeach
  <div style="text-align: center;">
  	<?php echo $articles->render(); ?>
  </div>
  
</div> <!-- /container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="jquery.min.js"><\/script>')</script>
<script src="bootstrap.min.js"></script>
@endsection