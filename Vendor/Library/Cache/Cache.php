<?php
namespace Vendor\Library\Cache;

/**
 * Cache - Class to generate chache file 
 * @access public 
 * @author Weslei A. Souza
 * @copyright	Copyright (c) 2013, ANDWES Solutions.
 * @link http://www.andwes.com.br
 * */


class Cache {
	
	public static $_time = '5 minutes';
	
	private $_folder;
	
	/**
	 * __construct - method construct 
	 * @access public
	 * @param $folder - Dir to storage cache file
	 * */
	public function __construct($folder = null)
	{
		$this->setFolder(!is_null($folder) ? $folder : sys_get_temp_dir());
	}
	
	
	/**
	 * setFolder - method to create folder to storage cache file 
	 * @access public
	 * @param $folder - Dir to storage cache file
	 * @return void
	 * */
	public function setFolder($folder)
	{
		if(is_dir($folder) && file_exists($folder) && is_writable($folder)){
			$this->_folder = $folder;
		}else{
			exit("Erro in ".__CLASS__.": $folder not exist or not have permission!");
		}
	}
	
	
	/**
	 * generateCache - method to create cache file 
	 * @access private
	 * @param $key - Key reference from cache file
	 * @return TMP cache file
	 * */
	private function generateCache($key)
	{
		return $this->_folder.DIRECTORY_SEPARATOR.sha1($key).'.tmp';
	}
	
	
	/**
	 * createFileCache - method to create cache file and put content into cache file 
	 * @access private
	 * @param $key - Key reference from cache file
	 * @param $content - Content from cache file
	 * @return boolean
	 * */
	private function createFileCache($key, $content)
	{
		$filename = $this->generateCache($key);
		
		$return  = file_put_contents($filename,$content);
		if( !$return ){
			exit("Erro in :".__CLASS__." do not could create $key!");
		}
		return $return;
	}
	
	
	/**
	 * saveCache - method to create  and save cache file and put content into cache file 
	 * @access public
	 * @param $key - Key reference from cache file
	 * @param $content - Content from cache file
	 * @param $time - Time to define life time from cache file
	 * @return createFileCache
	 * */
	public function saveCache($key,$content,$time = null)
	{
		$time = strtotime(!is_null($time) ? $time : self::$_time);
		$content = serialize(array(
			'expires'=>$time,
			'content'=>$content
		));
		
		return $this->createFileCache($key, $content);
	}
	
	
	/**
	 * readCache - method to read  content from cache file 
	 * @access public
	 * @param $key - Key reference from cache file
	 * @return createFileCache
	 * */
	public function readCache($key)
	{
		$filename = $this->generateCache($key);
		if(file_exists($filename) && is_readable($filename)){
			$cache = unserialize(file_get_contents($filename));
			if($cache['expires'] > time()){
				return $cache['content'];
			}else{
				unlink($filename);
			}
		}
		return null;
	}
}
