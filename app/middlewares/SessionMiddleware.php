<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Silex\Application;

include('interfaces\IMiddleware.php');

class SessionMiddleware implements IMiddleware{

	public function validate(Request $request, Application $app){
		
	    //Controle de acesso
	    $session = $request->getSession();
	    if(!$session->get('user')){
	      return new RedirectResponse('teste/Victor');
	    }
	}
}