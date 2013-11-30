<?php
namespace Vendor\Library\Form;
/**
 * Class Form - Library para auxiliar na criação de Formulários
 * @access public 
 * @author Weslei A. Souza
 * @link webdesigner.ibc@gmail.com
 * */
 
class Form {
	
	protected $_html;
	
	/**
	 * form_open - Método para iniciar o formulário
	 * @access public
	 * @param $name - Nome do formulárop
	 * @param $method - Método de envio de dados do Formulário
	 * @param $action - URL para o envio dos dados
	 * @param $extra - Configuração extra para o formulário
	 * @return String
	 * */
	public function form_open($name ,$method,$action,$extra = null){
		$extra = ($extra != null ? $extra : null);
		$return ="<form name='$name' method='$method' action='$action' $extra>";
		return $this->_html = $return;
	}
	
	public function form_hidden($name,$value = '',$extra=null){
		$extra = ($extra != null ? $extra : null);
		$return = "<input type='hidden' name='$name' value='$value' $extra />";
		return $this->_html .= $return;
	}
	
	public function form_input($name,$value = '',$extra=null){
		$extra = ($extra != null ? $extra : null);
		$return = "<input type='text' name='$name' value='$value' $extra />";
		return $this->_html .= $return;
	}
	
	public function form_password($name,$value = '',$extra=null){
		$extra = ($extra != null ? $extra : null);
		$return = "<input type='password' name='$name' value='$value' $extra />";
		return $this->_html .= $return;
	}
	
	public function form_label($label,$extra=null){
		$extra = ($extra != null ? $extra : null);
		$return = "<label $extra>$label</label>";
		return $this->_html .= $return;
	}
	
	public function form_select($name,array $option,$selected = null,$extra = null){
		$extra = ($extra != null ? $extra : null);
		$return = "<select name='$name' $extra>";
		foreach($option as $key => $value){
			if($selected == $key){
		$return .= "<option value='$key' selected>$value</option>";
			}else{
		$return .= "<option value='$key'>$value</option>";
			}
		}
		$return .= "</select>";
		return $this->_html .= $return;
	}
	
	public function form_radio($name,array $option,$checked = null,$extra=null){
		$extra = ($extra != null ? $extra : null);
		$return = '';
		foreach($option as $key => $value){
			if($key == $checked){
				$return .= "<input type='radio' name='$name' value='$key' checked $extra />$value"; 
			}else{
				$return .= "<input type='radio' name='$name' value='$key' $extra />$value"; 
			}
		}
		return $this->_html .= $return;
	}
	
	public function form_checkbox($name,array $option,$checked = null,$extra=null){
		$extra = ($extra != null ? $extra : null);
		$return = '';
		foreach($option as $key => $value){
			if($key == $checked){
				$return .= "<input type='checkbox' name='$name' value='$key' checked $extra />$value"; 
			}else{
				$return .= "<input type='checkbox' name='$name' value='$key' $extra />$value"; 
			}
		}
		return $this->_html .= $return;
	}
	
	public function form_textarea($name,$value,$cols= 40,$rows = 5,$extra=null){
			$extra = ($extra != null ? $extra : null);
			$return = "<textarea cols=\"$cols\" rows=\"$rows\" name=\"$name\">$value</textarea>";
			
		return $this->_html .= $return;
	}
	
	public function form_submit($value,$extra=null){
		$extra = ($extra != null ? $extra : null);
		$return = "<input type='submit' value='$value' $extra />";
		return $this->_html .= $return;
		}
	
	public function form_button($value,$extra=null){
		$extra = ($extra != null ? $extra : null);
		$return = "<input type='button' value='$value' $extra />";
		return $this->_html .= $return;
	}
	
	public function form_br($num = 1){
		return $this->_html .= str_repeat('<br />', $num);
	}
	
	public function render(){
		$this->_html .= '</form>';
		echo $this->_html;
	}
	
	
}
