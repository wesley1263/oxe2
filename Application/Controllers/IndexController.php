<?php
use Vendor\Core\OXE_Controller;
use Application\Models\Teste;
use Vendor\Library\Pagination\Pagination;
use Vendor\Library\Language\Language;
use Vendor\Library\Cache\Cache;
use Vendor\Library\PHPMailer\PHPMailer;
use Vendor\Library\Route\Route;


class IndexController extends OXE_Controller {

	public function init() {
		ini_set('default_charset','utf8');
		
	}

	public function indexAction() 
	{
		$teste = new Teste();
		$data['title'] = 'Pagina inicial';
		echo substr(__FUNCTION__,0,-6);	
	
		$this->view('index/index',$data);
	}
	
	
	public function boletoAction()
	{
		echo substr(__FUNCTION__,0,-6);
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
	
	public function mailAction()
	{
		//Create a new PHPMailer instance
		$mail = new PHPMailer();
		//Set who the message is to be sent from
		$mail->setFrom('from@example.com', 'First Last');
		//Set an alternative reply-to address
		$mail->addReplyTo('replyto@example.com', 'First Last');
		//Set who the message is to be sent to
		$mail->addAddress('whoto@example.com', 'John Doe');
		//Set the subject line
		$mail->Subject = 'PHPMailer mail() test';
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		$mail->msgHTML('Hello world');
		//Replace the plain text body with one created manually
		$mail->AltBody = 'This is a plain-text message body';
		//Attach an image file
		$mail->addAttachment('images/phpmailer_mini.gif');
		
		//send the message, check for errors
		if (!$mail->send()) {
		    echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
		    echo "Message sent!";
		}
	}
	
	public function routeAction()
	{
		echo 'EU sou route';
	}

}
