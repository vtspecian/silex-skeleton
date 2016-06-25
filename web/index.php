<?php
require_once __DIR__.'/../vendor/autoload.php';

//Para o uso nos middlewares
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

//Template engine php
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\Helper\SlotsHelper;

$app = new Silex\Application();

//Exibe erros na tela
$app['debug'] = true;

//registra conexões com o banco de dados
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'dbs.options' => include 'config/database.php',
));

//carrega todos os models e middlewares
include('models/autoload.php');
include('middlewares/autoload.php');

//onde será carregado o middleware
$middleware = array();

//carrega todos os middlewares
$dirMiddlewares     = 'middlewares/';
$pastaMiddlewares   = opendir($dirMiddlewares);

while ($arquivo = readdir($pastaMiddlewares)){

  //verificação para exibir apenas os arquivos e nao os caminhos para diretorios superiores 
  if ($arquivo != '.' && $arquivo != '..'){

    //verifica se o sufixo é Middleware
    $middlewareExplode = explode('Middleware', $arquivo);    
    if(sizeof($middlewareExplode) == 2){

      $middlewareClassName = explode('.php', $arquivo);
      $ObjMiddleware = new $middlewareClassName[0]();

      if(is_object($ObjMiddleware)){
        $middleware[strtolower($middlewareExplode[0])] = function (Request $request, Application $app) use($ObjMiddleware) {    
            return $ObjMiddleware->validate();
        };
      }
    }
  }
}

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
          __DIR__.'\views\\'.$controllerName.'\%name%',
          __DIR__.'\views\templates\%name%'
        ));
        $nameParser = new TemplateNameParser();
        $templating = new PhpEngine($nameParser, $loader);

        $templating->set(new SlotsHelper());

        return $templating;
      });

      //adicionando o controller
      $app->mount('/'.$controllerName, include 'controllers/'.$arquivo);
    }
  }
}

$app->run();