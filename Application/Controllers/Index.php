<?php
use Vendor\Core\OXE_Controller;
use Application\Models\Teste;
use Vendor\Library\Pagination\Pagination;


class Index extends OXE_Controller {

	public function init() {
		ini_set('default_charset','utf8');
		$this->pagination = new Pagination();
	}

	public function main() 
	{
		$teste = new Teste();
		$data['title'] = 'Pagina inicial';
		// echo phpversion();
		
		$this->view('index/index',$data);
	}
	
	public function boleto()
	{
		$teste = new Teste();
		$data = $teste->lista_count();
		
		$inicio = $this->pagination->init();
		$limite = 15;
		$this->pagination->setLimit($limite);
		$this->pagination->setParam('teste');
		$this->pagination->setTotalRegister($data);
		
		
		$data['listas'] = $teste->list_all($inicio, $limite);
		
		$this->view('index/pagination',$data);
	}



}
