<?php
namespace Vendor\Core;

use Vendor\Core\OXE_Database;

class OXE_Model extends OXE_Database{
	
	public function __construct(){
		parent::__construct(DRIVER, HOST, DBNAME, USERNAME, PASSWORD, CHARSET);
	}
}
