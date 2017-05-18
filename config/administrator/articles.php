<?php

return [
	'title' => 'articles',
	'single' => 'article',
	'model' => 'App\Article',
	'columns' => [
		'id',
		'title',
		'description',
		'text',
		'adding_date',
		'id_user',
		'id_partition'
	],
	'edit_fields' => [
		'title' => ['type' => 'text',],
		'description' => ['type' => 'text',],
		'text' => ['type' => 'text',],
		'id_partition' => ['type' => 'number',],
	],
];

?>