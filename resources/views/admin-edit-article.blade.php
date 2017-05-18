@extends('layouts.app')

@section('content')

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		<h1 class="text-center">Редактирование статьи</h1>
	</div>
</div>

<div class="container">
	<div class="form">
		<form method="POST" action="{{ route('save.article') }}">
			<div class="form-group">
				<label for="title">Заголовок</label>
				<input type="text" class="form-control" id="title" name="title" value="{{ $article->title }}">
			</div>
			<div class="form-group">
				<label for="description">Краткое описание</label>
				<textarea type="text" class="form-control" id="description" name="description">{{ $article->description }}</textarea>
			</div>
			<div class="form-group">
				<label for="text">Текст статьи</label>
				<textarea type="text" class="form-control" id="text" name="text">{{ $article->text }}</textarea>
			</div>
			
			<div class="form-group">
				<?php
			  		$partitions = DB::table('partitions')
			  							->select('id', 'partition')->get();
			    	$part = [];
			    	
			    	echo "<label for=\"partition\">Раздел</label><br>";
			    	echo "<select name=\"partition\" id=\"partition\">";
			    	foreach($partitions as $partition)
			    	{
						if($partition->id == $article->id_partition)
							echo "<option selected value=\"".$partition->id."\">".$partition->partition."</option>";
						else
							echo "<option value=\"".$partition->id."\">".$partition->partition."</option>";
					}
					echo "</select>";
			  	?>
			</div>
			
			<input type="hidden" name="id_article" id="id_article" value= "{{ $article->id }}">
			<button type="submit" class="btn btn-default">Сохранить изменения</button>
			{{ csrf_field() }}
		</form>
	</div>
</div> <!-- /container -->

@endsection