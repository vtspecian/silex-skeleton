<?php
require_once __DIR__.'/../vendor/autoload.php';

//Template engine php
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;

$app = new Silex\Application();

//Exibe erros na tela
$app['debug'] = true;

//carrega todos os controllers
$dirControllers   	= 'controllers/';
$pastaControllers 	= opendir($dirControllers);

while ($arquivo = readdir($pastaControllers)){

  //verificação para exibir apenas os arquivos e nao os caminhos para diretorios superiores 
  if ($arquivo != '.' && $arquivo != '..'){

    //verifica se o sufixo é Controller
    $controller = explode('Controller', $arquivo);
    if(sizeof($controller) == 2){
      $controllerName = strtolower($controller[0]);

      //registrando template engine deste controller
      $app['templating-'.$controllerName] = $app->share(function() use($controllerName) {
        $loader = new FilesystemLoader(array(
          __DIR__.'\views\\'.$controllerName.'\%name%'
        ));
        $nameParser = new TemplateNameParser();
        $templating = new PhpEngine($nameParser, $loader);
        return $templating;
      });

      //adicionando o controller
      $app->mount('/'.$controllerName, include 'controllers/'.$arquivo);
    }
  }
}

$app->run();