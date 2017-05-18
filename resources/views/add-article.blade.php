@extends('layouts.app')

@section('content')

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		<h1 class="text-center">Добавление статьи</h1>
	</div>
</div>

<div class="container">
	<div class="form">
		<form method="POST" action="{{ route('storeArticle') }}">
			<div class="form-group">
				<label for="title">Заголовок</label>
				<input type="text" class="form-control" id="title" name="title">
			</div>
			<div class="form-group">
				<label for="description">Краткое описание</label>
				<textarea type="text" class="form-control" id="description" name="description"></textarea>
			</div>
			<div class="form-group">
				<label for="text">Текст статьи</label>
				<textarea type="text" class="form-control" id="text" name="text"></textarea>
			</div>
			
			<div class="form-group">
				<?php
			  		$partitions = DB::table('partitions')
			  							->select('partition')->get();
			    	$part = [];
			    	
			    	echo "<label for=\"partition\">Раздел</label><br>";
			    	echo "<select name=\"partition\" id=\"partition\">";
			    	foreach($partitions as $partition)
			    	{
						//array_push($part, $partition->partition);
						echo "<option value=\"".$partition->partition."\">".$partition->partition."</option>";
					}
					echo "</select>";
			  	?>
			</div>
			
			<input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
			<button type="submit" class="btn btn-default">Добавить</button>
			{{ csrf_field() }}
		</form>
	</div>
</div> <!-- /container -->

@endsection