<?php
use Vendor\Core\OXE_Controller;
use Application\Models\Teste;
use Vendor\Library\Pagination\Pagination;
use Vendor\Library\Language\Language;

class Index extends OXE_Controller {

	public function init() {
		ini_set('default_charset','utf8');
		
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
		$pag = new Pagination();
		$teste = new Teste();
		$data = $teste->lista_count();
		
		$inicio = $pag->init();
		$limite = 15;
		$pag->setLimit($limite);
		$pag->setParam('pagina');
		$pag->setTotalRegister($data);
		
		$data['listas'] = $teste->list_all($inicio, $limite);
		$data['pag'] = $pag;
		$this->view('index/pagination',$data);
	}

	public function teste()
	{
		$langua = new Language();
		$langua->loadLanguage('pt');
		echo $langua->translator('title');
		// $this->dump($teste);
	}

}
