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

//registrando sessão
$app->register(new Silex\Provider\SessionServiceProvider());

//carrega todos os models e middlewares
include('models/autoload.php');
include('middlewares/autoload.php');

//onde será carregado os middlewares
$middleware = array();

//carrega todos os middlewares
$dirMiddlewares = opendir('middlewares/');

while ($arquivo = readdir($dirMiddlewares)){

  //verificação para exibir apenas os arquivos e nao os caminhos para diretorios superiores 
  if ($arquivo != '.' && $arquivo != '..'){

    //verifica se o sufixo é Middleware
    $middlewareExplode = explode('Middleware', $arquivo);    
    if(sizeof($middlewareExplode) == 2){

      //Pega o nome da classe
      $middlewareFileExplode = explode('.php', $arquivo);

      //Instância a classe
      $ObjMiddleware = new $middlewareFileExplode[0]();

      //Se for um objeto, adiciona na array de middlewares
      if(is_object($ObjMiddleware)){
        $middleware[strtolower($middlewareExplode[0])] = function (Request $request, Application $app) use($ObjMiddleware) {    
            return $ObjMiddleware->validate($request, $app);
        };
      }
    }
  }
}

//carrega todos os controllers
$dirControllers 	= opendir('controllers/');

while ($arquivo = readdir($dirControllers)){

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