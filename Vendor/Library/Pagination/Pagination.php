<?php
namespace Vendor\Library\Pagination;
use Vendor\Core\OXE_Model;

/**
 * Pagination - Class to create pagination of database
 * @name Pagination
 * @access public
 * @author Weslei A. Souza
 * @copyright	Copyright (c) 2013, ANDWES Solutions.
 * @link http://www.andwes.com.br
 * */

class Pagination extends OXE_Model {
	
	private $_table;
	private $_limit = 5;
	private $_param;
	private $_init;
	private $_totalRegister;
	
	
	
	public function __construct()
	{
		parent::__construct();
	}

	
	
/**
 * setLimit - Method to set limit per page
 * @name setLimit
 * @access public
 * @param $limit - number or String Table name 
 * @return void 
 * @author Weslei A. Souza
 * @copyright	Copyright (c) 2013, ANDWES Solutions.
 * */
	public function setLimit($limit)
	{
		$this->_limit = $limit;
		// echo  $this->_limit.'<br>';
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
		return $totalPage;
	}
	
	
	public function init()
	{
		$url = explode('/',$_GET['url']);
		array_shift($url);
		array_shift($url);
		array_shift($url);
		$init = ($url[0] * $this->_limit) - $this->_limit;
		return $this->_init = $init;
	}
	
	
	private function getParam(){
		$uri = explode('/',$_SERVER['REQUEST_URI']);
		array_shift($uri);
		array_pop($uri); 
		array_pop($uri); 
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
		$pagina = $this->getParam($this->_param);
		if(!isset($pagina)){
			$pagina = 1;
		}
		
		for($i = 1;$i<=$this->totalPage();$i++){
			if($i == $pagina){
				echo "<strong>$i</strong>";
			}else{
				$uri = $this->getParam();
				$param = $this->_param;
				$url = '/'.$uri[0].'/'.$uri[1].'/'.$param.'/'.$i;
				echo "<a href=\"$url\">$i $separator</a>";
			}
		}
	}
	
	public function next()
	{
		
	}
	
	
	public function previous()
	{
		
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
