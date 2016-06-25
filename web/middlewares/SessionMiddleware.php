<?php

use Symfony\Component\HttpFoundation\RedirectResponse;

include('interfaces\IMiddleware.php');

class SessionMiddleware implements IMiddleware{

	public function validate(){
		/*
	    //Controle de acesso
	    if(){
	      return new RedirectResponse('/login');
	    }
	   	*/
	}
}