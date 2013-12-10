<?php

if(version_compare(PHP_VERSION, '5.3.0','<')){
	exit("Desculpe, Esse framework não pode ser executado em uma versão inferior a PHP 5.3.0!\n");
}

require_once('config/dbconfig.php');
require_once('config/config.php');
require_once('config/autoload.php');
require_once('config/bootstrap.php');
 