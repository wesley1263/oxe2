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
		$this->pagination->setParam('pagina');
		$this->pagination->setTotalRegister($data);
		
		
		$lista = $teste->list_all($inicio, $limite);
		echo '<pre>';
		foreach($lista as $key => $value){
			foreach($value as $key => $va){
				echo $va.'<br>';
			}
		}
		echo '</pre>';
		
		echo $this->pagination->first();
		$this->pagination->pagination();
		echo $this->pagination->last();
	}



}
