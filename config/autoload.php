<?php
namespace Oxe\Config;
use Vendor\Core\Request;
use Vendor\Core\Router;
use Vendor\Core\OXE_Controller;
use Vendor\Core\OXE_Model;




spl_autoload_register(function ($class)
	{
		$file = str_replace(array('\\'),DIRECTORY_SEPARATOR,$class).'.php';
		$path = $file;
		if(file_exists($path)){
			require_once($path);
		}else{
			exit("Erro 00: $path Not Found!");
		}
	}
);

