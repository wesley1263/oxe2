<?php
use Vendor\Core\OXE_Controller;
use Application\Models\Teste;
use Vendor\Library\Cache\Cache;
use Vendor\Library\OpenBoleto\Src\OpenBoleto\Agente;
use Vendor\Library\OpenBoleto\Src\OpenBoleto\Banco\BancoDoBrasil;


class Index extends OXE_Controller {

	public function init() {

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
		
		
	}



}
