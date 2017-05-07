@extends('layouts.app')

@section('content')
<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h1 class="text-center">Раздел статей</h1>
  </div>
</div>

<div class="container">
  
  @foreach($articles as $article)
  	<div class="row">
      <h2> {{ $article->title }} </h2>
      <p> {!! $article->description !!} </p>
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