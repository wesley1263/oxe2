<?php

namespace Vendor\Library\Language;

/**
 * Class to translater the application 
 * @name Pagination
 * @access public
 * @author Weslei A. Souza
 * @copyright	Copyright (c) 2013, ANDWES Solutions.
 * @link http://www.andwes.com.br
 * */
 
 class Language {
 	
	private $_folder;
	private $_key;
	private $language = array();
	
	
	/**
 * method to load folder where contain legends 
 * @name loadLanguage
 * @access public
 * @param String name folder 
 * @return String
 * @author Weslei A. Souza
 * @copyright	Copyright (c) 2013, ANDWES Solutions.
 * @link http://www.andwes.com.br
 * */
	public function loadLanguage($folder)
	{
		$this->_folder = LANGUAGE_PATH.$folder.'/language.php';
		if(!file_exists($this->_folder)){
			self::error("This $this->_folder do not exist!");
		}
		include($this->_folder);
		
		$this->language = $lang;
	}
	
	
/**
 * method to print line from file language 
 * @name translator
 * @access public
 * @param String name key 
 * @return String
 * @author Weslei A. Souza
 * @copyright	Copyright (c) 2013, ANDWES Solutions.
 * @link http://www.andwes.com.br
 * */
	
	public function translator($key)
	{
		return $this->language[$key];
	}
	
	public static function error($error)
	{
		exit("<pre>Error in library Language: ".$error.'</pre>');
	}
 }
