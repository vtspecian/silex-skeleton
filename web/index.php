<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

//carrega todos os controllers
$dirControllers   = 'controllers/';
$pastaControllers = opendir($dirControllers);

while ($arquivo = readdir($pastaControllers)){
	//verificacao para exibir apenas os arquivos e nao os caminhos para diretorios superiores 
	if ($arquivo != '.' && $arquivo != '..'){
		$controller = explode('Controller', $arquivo);
		if(sizeof($controller) == 2){
			$controllerName = strtolower($controller[0]);
			$app->mount('/'.$controllerName, include 'controllers/'.$arquivo);	
		}
	}
}

$app->run();