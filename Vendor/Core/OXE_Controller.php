<?php
namespace Vendor\Core;
 
/**
 * Class OXE_Controller  - Classe principal para outras  classes
 * @access public 
 * @author Weslei A. Souza
 * @link http: //www.andwes.com.br
 * @copyright	Copyright (c) 2013, ANDWES Solutions.
 * */
 
 abstract class OXE_Controller {
 	
	
	/**
	 * __construct - Construct Method
	 * @access public 
	 * @return void
	 * */
	
	public function __construct(){
		$this->init();
	}
	
	
	/**
	 * init - Construct Method abstract
	 * @access public 
	 * @author Weslei A. Souza
	 * @return void
	 * @copyright	Copyright (c) 2013, ANDWES Solutions.
	 * */
	public function init(){
		
	}
	
	
	/**
	 * view - Method to load views 
	 * @access public 
	 * @param $name - File name with extension .phtml 
	 * @param $vars - Variables to file in format array 
	 * @return Mixed
	 * @author Weslei A. Souza
	 * @copyright	Copyright (c) 2013, ANDWES Solutions.
	 * */
	public function view($name,$vars = null){
		$file_view = VIEW_PATH.$name.'.phtml';
		if(file_exists($file_view)){
			require($file_view);
			
			if(is_array($vars) && count($vars) > 0){
				extract($vars);
			}else{
				self::error("Erro 04 - Variable Empty!");
			}
		}else{
			self::error("Erro 03 - File $file_view Not Found!");
		}
		
	}
	
	
	
	/**
	 * error - Method show error
	 * @access static
	 * @param  error - Erro message from this class
	 * @return String
	 * @author Weslei A. Souza
	 * @copyright	Copyright (c) 2013, ANDWES Solutions.
	 * */
	public static function error($erro){
		return exit($erro);
	}
	
	
	/**
	 * redirector - Method to redirenct to any url in the framework 
	 * @access public
	 * @param  $url - Url to redirect 
	 * @return void
	 * @author Weslei A. Souza
	 * @copyright	Copyright (c) 2013, ANDWES Solutions.
	 * */
	public function redirector($url){
		if(!isset($url)){
			self::error("Erro in the Controller: redirector need param!");
		}else{
			return header('Location: '.$url);
		}
	}
	
	
	/**
	 * baseUrl - Method to print URL from application
	 * @access public
	 * @param  $url - url from Controller/Action
	 * @return String
	 * @author Weslei A. Souza
	 * @copyright	Copyright (c) 2013, ANDWES Solutions.
	 * */
	public function baseUrl($url = null)
	{
		$url = trim($url);
		$return;
		if($url == null){
			$return = $_SERVER['HTTP_HOST'].'/';
		}else{
			$return = $_SERVER['HTTP_HOST'].'/'.$url;
		}
		return $return;
		
	}
	
	
	/**
	 * getParam - Method to catch param from url 
	 * @access public
	 * @return Array
	 * @author Weslei A. Souza
	 * @copyright	Copyright (c) 2013, ANDWES Solutions.
	 * */
	 public function getParam()
	 {
	 	$param = explode('/',$_REQUEST['url']);
		array_shift($param);
		array_shift($param);
		return array($param[0] => $param[1]);
	 }
 }
 