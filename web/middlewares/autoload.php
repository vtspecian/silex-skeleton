<?php
spl_autoload_register(function ($class_name) {
	if(file_exists(__DIR__.'\..\middlewares\\'.$class_name . '.php')){
		include(__DIR__.'\..\middlewares\\'.$class_name . '.php');
	}
});