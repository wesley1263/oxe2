<?php
namespace Vendor\Core;

use Vendor\Core\Request;
/**
 * Router - Classe responsável por mapear a rota das requisições
 * @access public
 * @author Weslei A.Souza
 * @link - http://www.agence.com.br
 * */

class Router {

	public static function Run(Request $request) {

		$controller = $request -> getController().'Controller';
		$action = $request -> getAction().'Action';
		$param = $request -> getParam();
		
		### Define Controller  files ###
		$file_controller = CONTROLLER_PATH . ucfirst($controller) . '.php';
		if (file_exists($file_controller)) {

			require ($file_controller);
			
		### Define Controller  ###
			if (class_exists($controller)) {
				$controller = new $controller();
			} else {
				self::error("Erro 02 - Class $controller Not Found!");
			}

			if (!is_callable(array($controller, $action))) {
				self::error("Erro 03 - Action $action Not Found!");
			}

			if (!empty($param)) {
				call_user_func_array(array($controller, $action), $param);
			} else {
				call_user_func(array($controller, $action));
			}
		}else{
			self::error("Erro 01 - $controller File Not Found!");
		}
	}

	public static function error($erro) {
		return exit($erro);
	}

}
