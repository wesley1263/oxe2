<?php
namespace Application\Models;

use Vendor\Core\OXE_Model;

class Teste extends OXE_Model {
		
	protected $_name = 'tbl_usuario';
	protected $_primary = 'id_user';
	
	public function __construct(){
		parent::__construct();
	}
	
	public function lista_count(){
		$this->select('post_title')
		     ->distinct()
			 ->from('pv_posts_w');
			 return $this->result();
	}
	
	public function list_all($inicio, $limit)
	{
		$this->select('post_title')
		     ->distinct()
			 ->from('pv_posts_w')
			 ->order_by('post_title')
			 ->limit($inicio,$limit);
			 return $this->result();
	}
	
	public function teste()
	{
		$this->select('post_title')
		     ->distinct()
			 ->from('pv_posts_w')
			 ->order_by('post_title')
			 ->limit(0,30);
			 return $this->console();
	}
	
}
