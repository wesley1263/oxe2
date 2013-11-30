<?php 
namespace Vendor\Core;
use PDO;
/**
 * OXE_Database - Abstract class to abstraction Database
 * @access abstract 
 * @author Weslei A. Souza
 * @link contato@andwes.com.br
 * @copyright	Copyright (c) 2013, ANDWES Solutions.
 * */

abstract class OXE_Database extends PDO {
	
	
	protected $_name;
	protected $_primary;
	private $db;
	
	
	/**
	 * __construct - construct method
	 * @access public  
	 * @author Weslei A. Souza
	 * @link contato@andwes.com.br
	 * @copyright	Copyright (c) 2013, ANDWES Solutions.
	 * */
	public function __construct($driver,$host,$dbname,$user,$pass,$charset = null){
		parent::__construct($driver.':host='.$host.';dbname='.$dbname,$user,$pass);
		if($charset != null){
			$this->exec("set names $charset");
		}
		$this->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	}
	
	
	/**
	 * fetchAll - Method to fetch all rows from table
	 * @access public 
	 * @author Weslei A. Souza
	 * @link contato@andwes.com.br
	 * @copyright	Copyright (c) 2013, ANDWES Solutions.
	 * @return Array
	 * */
	public function fetchAll(){
		try{
		$db = $this->prepare("SELECT * FROM $this->_name");
		$db->execute();
		return $db->fetchAll(PDO::FETCH_ASSOC);
			
		}catch(PDOException $e){
			exit($e->getMessage());
		}
	}
	
	
	/**
	 * fetch - Method to fetch one row from table
	 * @access public 
	 * @author Weslei A. Souza
	 * @param $cond  - Condicion to return
	 * @link contato@andwes.com.br
	 * @copyright	Copyright (c) 2013, ANDWES Solutions.
	 * @return Array
	 * */
	public function fetch($cond){
		try{
			$db = $this->prepare("SELECT * FROM {$this->_name} WHERE $cond");
			$db->execute();
			return $db->fetch($cond);
		}catch(PDOException $e){
			exit($e->getMessage());
		}
	}
	
	
	
	public function insert(array $data){
		try{
			$campos = implode(',', array_keys($data));
			$values = ':'.implode(',:', array_keys($data));
			$db = $this->prepare("INSERT INTO $this->_name ($campos) VALUES ($values)");
			foreach($data as $key => $value){
				$types = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
				$db->bindValue(":$key",$value,$types);
			}
			return $db->execute();
		}catch(PDOException $e){
			exit($e->getMessage());
		}
	}
	
	
	
	public function update($data, $cond){
		try{
			foreach($data as $keys => $values){
				$new_data[] = "$keys = :$keys";
			}
			$new_data = implode(',', $new_data);
			$db = $this->prepare("UDPATE $this->_name SET $new_data WHERE $cond");
			foreach($data as $key => $value){
				$types = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
				
				$db->bindValue(":$key",$value,$types);
			}
			return $db->execute();
		}catch(PDOException $e){
			exit($e->getMessage());
		}
	}
	
	
	public function delete($id){
		try{
			return $db->exec("DELETE FROM $this->_name WHERE $this->_primary = $id");
		}catch(PDOException $e){
			exit($e->getMessage());
		}
	}
	
	
	public function select($table,$cond = null){
		try{
			$cond = ($cond == null ? null : "WHERE ".$cond);
			$db = $this->prepare("SELECT * FROM $table $cond");
			$db->execute();
			return $db->fetchAll(PDO::FETCH_ASSOC);
		}catch(PDOException $e){
			exit($e->getMessage());
		}
	}
	
	
	public function query($query){
		try{
			$db = $this->prepare($query);
			$db->execute();
			return $db->fetchAll(PDO::FETCH_ASSOC);
		}catch(PDOException $e){
			exit($e->getMessage());
		}
	}
}
