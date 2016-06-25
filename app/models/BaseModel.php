<?php

abstract class BaseModel{

	protected $app;
	protected $db;

	function __construct($app){
		$this->app 	= $app;
		$this->db 	= $app['dbs']['mysql'];
	}
}