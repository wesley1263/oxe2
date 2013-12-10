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
	private $_select = '*';
	private $_distinct;
	private $_from;
	private $_where = array();
	private $_limit;
	private $_or;
	private $_join;
	private $_order;
	
	
	/**
	 * __construct - construct method
	 * @access public  
	 * @author Weslei A. Souza
	 * @link contato@andwes.com.br
	 * @copyright	Copyright (c) 2013, ANDWES Solutions.
	 * */
	public function __construct($driver,$host,$dbname,$user,$pass,$charset = null)
	{
		parent::__construct($driver.':host='.$host.';dbname='.$dbname,$user,$pass);
		if($charset != null){
			$this->exec("set names $charset");
		}
		$this->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		
		if(method_exists(__CLASS__, 'where')){
			$this->query .= 'WHERE TRUE ';
		}
	}
	
	public function __call($method,$arg)
	{
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
	public function fetchAll()
	{
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
	public function fetch($cond)
	{
		try{
			$db = $this->prepare("SELECT * FROM {$this->_name} WHERE $cond");
			$db->execute();
			return $db->fetch($cond);
		}catch(PDOException $e){
			exit($e->getMessage());
		}
	}
	
	
	
	public function insert(array $data)
	{
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
	
	
	
	public function update($data, $cond)
	{
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
	
	
	public function delete($id)
	{
		try{
			return $db->exec("DELETE FROM $this->_name WHERE $this->_primary = $id");
		}catch(PDOException $e){
			exit($e->getMessage());
		}
	}
	
	
	public function select($rows = '*'){
		
		if(is_array($rows) && count($rows) > 0)
		{
			$rows = implode(',', $rows);
		}
		$sql = "$rows";
		$this->_select = $sql;
		return $this;
	}
	
	public function distinct(){
		$this->_distinct = 'DISTINCT';
		return $this;
	}
	
	
	public function from($table,$alias = null)
	{
		if($alias != null){
			$alias = "AS $alias";
		}
		$sql = "FROM $table $alias WHERE TRUE ";
		$this->_from = $sql;
		return $this;
	}
	
	public function where($cond)
	{
		$this->_where[] = "AND ($cond)";
		return $this;
	}
	
	public function limit($init,$limit = null)
	{
		$limit = (is_null($limit)) ? null : ", $limit";
		$sql = "LIMIT $init $limit";
		$this->_limit = $sql;
		return $this;
	}
	
	
	public function join(array $table,$on,$type = 'INNER')
	{
		$tableName = null;
		$alias = null;
		foreach($table as $key => $value){
			$tableName = $key;
			$alias = $value;
		}
		$sql = "$type JOIN $tableName AS $alias ON ($on) ";
		$this->_join = $sql;
		return $this;
	}
	
	public function where_or($cond)
	{
		$sql = "OR ($cond) ";
		$this->_or = $sql;
		return $this;	
	}
	
	
	public function order_by($data, $asc = 'ASC')
	{
		if(is_array($data)){
			$data = implode(',',$data);
		}
		$sql = "ORDER BY $data $asc";
		$this->_order = $sql;
		return $this;
	}	
	
	
	public function result()
	{
		if(is_array($this->_where) && count($this->_where)){
			$this->_where = implode($this->_where, '  ');
		}else{
			$this->_where = null;
		}
		$this->query = "SELECT $this->_distinct $this->_select $this->_from  $this->_join  $this->_where $this->_or  $this->_order $this->_limit";
		try{
		$db = $this->prepare($this->query);
		$db->execute();
		return $db->fetchAll(PDO::FETCH_ASSOC);	
		}catch(PDOException $e){
			echo $e->getMessage();
		}	
				
	}
	
	public function console()
	{
		if(is_array($this->_where) && count($this->_where)){
			$this->_where = implode($this->_where, '  ');
		}else{
			$this->_where = null;
		}
		
		echo $this->query = "SELECT $this->_distinct $this->_select $this->_from $this->_join $this->_where $this->_or  $this->_order $this->_limit";
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
