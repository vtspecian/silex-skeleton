<?php
$controller = $app['controllers_factory'];

$controller->get('/{name}', function ($name) use ($app) {
  $data = [
    'nome' => $app->escape($name)
  ];
  return $app['templating-hello']->render('hello.php', $data);
});

return $controller;