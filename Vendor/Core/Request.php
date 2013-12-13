<?php
namespace Vendor\Core;

/**
 * Class Request - Classe responsável por separar url 
 * @access public
 * @author Weslei A. Souza
 * @link webdesigner.ibc@gmail.com
 * 
 * */
 
class Request {
 	
	private $_Controller = 'index';
	private $_Action = 'index';
	private $_Param = array();
	
	
	/**
	 * @name __constuct - Método construtor que trata a url e separa controller,action e parametros
	 * @access public 
	 * @return void
	 * */
	public function __construct(){
		if(!isset($_GET['url'])){
			return false;
		}		
		
		$request = explode('/', $_GET['url']);
		
		$this->_Controller = ($c = array_shift($request))? $c : 'index';
		$this->_Action = ($a = array_shift($request)) ? $a : 'index';
		$this->_Param = (isset($request[0])?$request: array());
	}
	
	/**
	 * @name getController - Retorna o controller chamado na url
	 * @access public 
	 * @return String
	 * */
	public function getController(){
		return $this->_Controller;
	}
	
	
	/**
	 * @name getAction - Retorna o Action chamado na url
	 * @access public 
	 * @return String
	 * */
	public function getAction(){
		return $this->_Action;
	}
	
	
	/**
	 * @name getParama - Retorna os parametos chamados na url
	 * @access public 
	 * @return String
	 * */
	public function getParam(){
		return $this->_Param;
	}
 }
