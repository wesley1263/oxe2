<?php
namespace Vendor\Library\Mail;
/**
 * Classe responsável por enviar email
 * @name Mail 
 * @author Weslei A. Souza
 * @access public
 * @link http://www.andwes.com.br
 * */
 
class Mail {
	
	private $_to;
	private $_subject;
	private $_from;
	private $_message;
	
	
	public function valid_email($email)
	{
		
		return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) ? FALSE : TRUE;
	}
	
	
	public function To($to)
	{
		$to = strip_tags($to);
		$this->valid_email($to);
		return $this;
	}
	
	
	public function Subject($subject)
	{
		$this->_subject = strip_tags($subject);
		return $this;
	}
	
	
	public function From($from)
	{
		$from = strip_tags($from);
		$this->valid_email($from);
		$this->_from = $from;
		return $this;
	}
	
	
	public function Message($message)
	{
		$message = strip_tags($message);
		$this->_message = $message;
		return $this;
	}
	
	public function send()
	{
		$header = "MIME-Version: 1.1\n";
		$header .= "Content-Type: text/html; charset=utf8\n";
		$header .= "Reply-To:".$this->_to."\n";
		$header .= "X-Priority 3\n";
		
		return mail($this->_to, $this->_subject, $this->_message,$header,"-f".$this->_to);
		
	}
}
