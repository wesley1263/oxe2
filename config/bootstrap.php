<?php

if(version_compare(PHP_VERSION, '5.3.0','<')){
	exit("Desculpe, Esse framework não pode ser executado em uma versão inferior a PHP 5.3.0!\n");
}

Vendor\Core\Router::Run(new Vendor\Core\Request());