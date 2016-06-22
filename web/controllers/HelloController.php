<?php

$hello = $app['controllers_factory'];

$hello->get('/{name}', function ($name) use ($app) {

	$view = 'views/hello/hello.php';

	$data = [
		'nome' => $app->escape($name)
	];

	include $view;
	
	return '';
});

return $hello;