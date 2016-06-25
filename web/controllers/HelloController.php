<?php

$controller = $app['controllers_factory'];

$controller->get('/{name}', function ($name) use ($app) {
	
	$Produto = new ProdutoModel($app);
	$produtos = $Produto->findAll();

  $data = [
    'nome' 			=> $app->escape($name),
    'produtos' 	=> $produtos
  ];
  
  return $app['templating-hello']->render('hello.php', $data);

})->before($middleware['session']);

return $controller;