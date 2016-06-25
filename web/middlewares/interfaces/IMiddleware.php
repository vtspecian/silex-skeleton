<?php

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

interface IMiddleware{
	public function validate(Request $request, Application $app);
}