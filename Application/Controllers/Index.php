<?php
use Vendor\Core\OXE_Controller;
use Application\Models\Teste;

class Index extends OXE_Controller {

	public function init() {

	}

	public function main() {
		$teste = new Teste();
		$teste->lista_all();
		$data['title'] = 'Pagina inicial';
		
		$this->view('index/index',$data);
	}



}
