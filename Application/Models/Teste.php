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
			 ->from('tbl_usuario','user')
			 ->where('user.id_user = 4')
			 ->where('user.nome_user = \'JOSE\'')
			 ->where_or('user.id > 10')
			 ->join(array('teste' => 'tes'),'user.id = tes.id')
			 ->limit('100')
			 ->result();
	}
}
