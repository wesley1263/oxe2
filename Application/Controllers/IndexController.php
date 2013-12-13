<?php
use Vendor\Core\OXE_Controller;
use Application\Models\Teste;
use Vendor\Library\Pagination\Pagination;
use Vendor\Library\Language\Language;
use Vendor\Library\Cache\Cache;
class Index extends OXE_Controller {

	public function init() {
		ini_set('default_charset','utf8');
		
	}

	public function indexAction() 
	{
		$teste = new Teste();
		$data['title'] = 'Pagina inicial';
		// echo phpversion();
		
		$this->view('index/index',$data);
	}
	
	public function boletoAction()
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

	public function testeAction()
	{
		$langua = new Language();
		$langua->loadLanguage('en');
		echo $langua->translator('title');
	}
	
	public function correiosAction()
	{
		$data = array(
		'nCdEmpresa' =>'',
		'sDsSenha' =>'',
		'nCdServico' => '41106',
		'sCepOrigem' => '04429150',
		'sCepDestino' => '04431000',
		'nVlPeso' => '10',
		'nCdFormato' => 1,
		'nVlComprimento' => 16.0,
		'nVlAltura' => 15,
		'nVlLargura' => 15,
		'nVlDiametro' => 20,
		'sCdMaoPropria' => 'N',
		'nVlValorDeclarado' => 0,
		'sCdAvisoRecebimento' => 'S'
		);
		echo "<pre>";
		
		$cache = new Cache();
		$cache->setFolder(APPLICATION_PATH.'cache');
		
		$ws = new SoapClient('http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx?wsdl');
		$result = $ws->CalcPrecoPrazo($data);
		$cache->saveCache('correios', $result->CalcPrecoPrazoResult->Servicos->cServico->MsgErro);
		if($cache->readCache('correios')){
			echo $cache->readCache('correios');
		}else{
			echo $result->CalcPrecoPrazoResult->Servicos->cServico->MsgErro;
		}
	}

}
