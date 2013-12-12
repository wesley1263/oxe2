<?php
namespace Vendor\Library\Pagination;

/**
 * Pagination - Class to create pagination of database
 * @name Pagination
 * @access public
 * @author Weslei A. Souza
 * @copyright	Copyright (c) 2013, ANDWES Solutions.
 * @link http://www.andwes.com.br
 * */

class Pagination {
	
	private $_table;
	private $_limit = 15;
	private $_param;
	private $_init;
	private $_totalRegister;
	private $_totalPage;
	
	
	
	
/**
 * setLimit - Method to set limit per page
 * @name setLimit
 * @access public
 * @param $limit - number or String Table name 
 * @return void 
 * @author Weslei A. Souza
 * @copyright	Copyright (c) 2013, ANDWES Solutions.
 * */
	public function setLimit($limit = null)
	{
		$this->_limit = $limit;
		return $this->_limit;
	}

	
	public function __call($method,$args)
	{
		return exit("Error from ".__CLASS__." Library: This <strong>'$method'</strong> method do not exist!");
	}
	
/**
 * setParam - Method to set param of get
 * @name setParam
 * @access public
 * @param $param - Param name
 * @return void 
 * @author Weslei A. Souza
 * @copyright	Copyright (c) 2013, ANDWES Solutions.
 * */
	public function setParam($param = 'pag')
	{
		$this->_param = $param;
		return $this;
	}
	
		
	public function setTotalRegister($data)
	{
		$this->_totalRegister = count($data);
		return $this;
	}
	
	
	
	private function totalPage()
	{
		$totalPage = ceil($this->_totalRegister / $this->_limit);
		$this->_totalPage = $totalPage;
		return $totalPage;
	}
	
	
	public function init()
	{
		$limit = $this->_limit;
		$url = explode('/',$_GET['url']);
		array_shift($url);
		array_shift($url);
		array_shift($url);
		$init = ($url[0] * $limit) - $limit;
		return $this->_init = $init;
	}
	
	
	private function getParam(){
		$uri = explode('/',$_SERVER['REQUEST_URI']);
		array_shift($uri);
		array_pop($uri); 
		array_pop($uri); 
		return $uri;
	}
	
	private function getUri()
	{
		$uri = explode('/',$_SERVER['REQUEST_URI']);
		array_shift($uri);
		array_shift($uri);
		array_shift($uri);
		return $uri;
	}
	
	
	
	public function first($link = '<<')
	{
		$uri = $this->getParam(); 
		$param = $this->_param;
		$url = '/'.$uri[0].'/'.$uri[1].'/'.$param.'/1';
		return "<a href=\"$url\">$link</a>";
	}
	
	
	public function last($link = '>>')
	{
		$uri = $this->getParam();
		$param = $this->_param;
		$url = '/'.$uri[0].'/'.$uri[1].'/'.$param.'/'.$this->totalPage();
		return "<a href=\"$url\">$link</a>";
		
	}
	
	
	public function pagination($separator = ' | ')
	{
		$pagina = $this->getUri();
		// print_r($pagina);
		if(!$pagina){
			$pagina = 1;
		}
		
		for($i = 1;$i<=$this->totalPage();$i++){
			if($i == $pagina[1]){
				echo "<strong>$i $separator</strong>";
			}else{
				$uri = $this->getParam();
				$param = $this->_param;
				$url = '/'.$uri[0].'/'.$uri[1].'/'.$param.'/'.$i;
				echo "<a href=\"$url\">$i</a> $separator";
			}
			
		}
	}
	
	public function next($icon = ">")
	{
		$uri = explode('/',$_SERVER['REQUEST_URI']);
		$pag = array_pop($uri);
		
		$next = (int)$pag + 1;
		$url = implode($uri,'/');
		$return = " <a href=\"$url/$next\">$icon</a> ";
		if($this->_totalPage < $next){
			$return = " <a href=\"#\">$icon</a> ";
		}
		
		return $return;
		
	}
	
	
	public function previous($icon = "<")
	{
		$uri = explode('/',$_SERVER['REQUEST_URI']);
		$pag = array_pop($uri);
		$next = (int)$pag - 1;
		$url = implode($uri,'/');
		$return = "<a href=\"$url/$next\">$icon</a>";
		if($next < 1){
			$return = " <a href=\"#\">$icon</a> ";
		}
		return $return;
	}
	
	
	
		
/**
 * Error - Method to print Error
 * @name Error
 * @access private
 * @param $error - String Message Error
 * @return String 
 * @author Weslei A. Souza
 * @copyright	Copyright (c) 2013, ANDWES Solutions.
 * */
	private static function Error($error)
	{
		return exit('Error from Pagination: '.$error);
	}
	
	
}
