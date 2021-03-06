@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<h2>Личный кабинет</h2>
                	<?php
                		$isbanned = DB::table('bans')->select('id')->where('id_user', Auth::user()->id)->first();
                		if(isset($isbanned))
                		{
							echo "<h2 style=\"color: red;\">Вас забанили</h2>";
						}
                	?>
                </div>

                <div class="panel-body">
                    Теперь, после прохождения авторизации, Вам доступны комментирование и оценка контента!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
