<?php

$controller = $app['controllers_factory'];

$controller->get('/teste/{name}', function ($name) use ($app) {	

  $Produto = new ProdutoModel($app);
  $produtos = $Produto->findAll();

  $data = [
    'nome' 			=> $app->escape($name),
    'produtos' 	=> $produtos
  ];  

  return $app['templating-hello']->render('hello.php', $data);

});

$controller->get('/valida-sessao', function () use ($app) {	
  return $app['templating-hello']->render('hello2.php');

})->before($middleware['session']);


return $controller;