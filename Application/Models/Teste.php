<?php
namespace Application\Models;

use Vendor\Core\OXE_Model;

class Teste extends OXE_Model {
		
	protected $_name = 'tbl_usuario';
	protected $_primary = 'id_user';
	
	public function __construct(){
		parent::__construct();
	}
	
	public function lista_all(){
		$this->select()
			 ->from('teste','tes')
			 ->where('id_teste = 1')
			 ->where('nome_teste = joao')
			 ->result();
	}
}
