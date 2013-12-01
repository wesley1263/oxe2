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
	private $query;
	
	
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
		
		if(method_exists(__CLASS__, 'where')){
			$this->query .= 'WHERE TRUE ';
		}
	}
	
	public function __call($method,$arg){
		exit("Erro in the Model: Method <strong>'$method'</strong> not exist!");
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
	
	
	public function select($rows = '*'){
		
		if(is_array($rows) && count($rows) > 0){
			$rows = implode(',', $rows);
		}
		$sql = "SELECT $rows ";
		$this->query = $sql;
		return $this;
	}
	
	
	public function from($table,$alias = null){
		
		if($alias != null){
			$alias = "AS $alias";
		}
		$sql = "FROM $table $alias WHERE TRUE ";
		$this->query .= $sql;
		return $this;
	}
	
	public function where($cond){
		$sql = "AND $cond ";
		$this->query .= $sql;
		return $this;
	}
	
	public function limit($limit){
		$sql = "LIMIT $limit";
		$this->query .= $sql;
		return $this;
	}
	
	
	public function join(){
		
	}
	
	public function result(){
		echo $this->query;
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
