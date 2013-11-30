<?php 
namespace Vendor\Library\Session;

class Session {
	
	public function __construct(){
		session_start();
		session_regenerate_id();
	}
	 
	public function setSession($key,$value = null){
		if(is_array($key)){
			foreach($key as $keys => $values){
				$_SESSION[$keys] = $values;
			}
		}else{
			$_SESSION[$key] = $value;
		}
	}
	
	public function getSession($key){
		return $_SESSION[$key];
	}
	
	public function delSession($key){
		unset($_SESSION[$key]);
	} 
	
	public function destroySession(){
		return session_destroy();
	}
	
	public function setFlashMessage($string,$key){
		$_SESSION[$key] = $string;
	}	
	
	public function getFlashMessage($key){
		$var = self::getSession($key);
		self::delSession($key);
		return $var;
	}
	
}
