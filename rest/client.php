<?php

include_once 'vendor/autoload.php';

use \Curl\Curl;

class RestClient {
	
	const HOST = 'https://cloudapi.nomos-system.com/control/';
	const OUTPUT_FORMAT_JSON = 'application/json, text/javascript';
	const OUTPUT_FORMAT_XML = 'application/xml, text/xml';
	const OUTPUT_FORMAT_JSONP = 'application/javascript';
	
	private $accessToken;
	private $outputFormat;
	private $jsonpFunctionName;

	public function __construct($accessToken, $outputFormat = self::OUTPUT_FORMAT_JSON, $jsonpFunctionName = '') {
		$this->accessToken = $accessToken;
		$this->outputFormat = $outputFormat;
		$this->jsonpFunctionName = $jsonpFunctionName;
	}
	
	private function _call($method, $name, $parameters = array()) {
		$urlParameters = array();
		
		$curl = new Curl();
		$curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
		$curl->setHeader('Authorization', 'Bearer '.$this->accessToken);
		$curl->setHeader('Accept', $this->outputFormat);
		
		if($this->outputFormat === self::OUTPUT_FORMAT_JSONP) {
			$urlParameters['callback'] = $this->jsonpFunctionName; 
		}
		
		if($method === 'get') { 
			$curl->get(self::HOST.$name.'/?'.http_build_query($urlParameters), $parameters);
		}
		else {
			$curl->post(self::HOST.$name.'/?'.http_build_query($urlParameters), $parameters);
		}
		
		if ($curl->error) {
		    echo 'Error: ' . $curl->error_code . ': ' . $curl->error_message;
		}
		else {
		    echo $curl->raw_response;
		}
	}
	
	private function _get($name) {
		$this->_call('get', $name);
	}
	
	private function _post($name, $parameters) {
		$this->_call('post', $name, $parameters);
	}
	
	
	public function getUser() {
		$this->_get('user');
	}
	
	public function getSystems() {
		$this->_get('system');
	}
	
	public function getSystem($sid) {
		$this->_get('system/'.$sid);
	}
	
	public function getSystemOnlineState($sid) {
		$this->_get('system/'.$sid.'/online');
	}
	
	public function getSystemMeta($sid) {
		$this->_get('system/'.$sid.'/meta');
	}
	
	public function getSystemClasses($sid) {
		$this->_get('system/'.$sid.'/class');
	}
	
	public function getSystemClassCommands($sid, $className) {
		$this->_get('system/'.$sid.'/class/'.$className.'/command');
	}
	
	public function getSystemClassSetPropertiesCommands($sid, $className) {
		$this->_get('system/'.$sid.'/class/'.$className.'/set');
	}
	
	public function getSystemClassGetPropertiesCommands($sid, $className) {
		$this->_get('system/'.$sid.'/class/'.$className.'/get');
	}
	
	public function getSystemClassValues($sid, $className) {
		$this->_get('system/'.$sid.'/class/'.$className.'/value');
	}
	
	public function getSystemClassValue($sid, $className, $valueName) {
		$this->_get('system/'.$sid.'/class/'.$className.'/value/'.$valueName);
	}
	
	public function executeRaw($sid, $json) {
		$this->_post('system/'.$sid.'/raw', array('param' => $json));
	}
	
	public function executeSystemClassCommand($sid, $className, $commandName, $parameters = '') {
		$this->_post('system/'.$sid.'/class/'.$className.'/command/'.$commandName, array('param' => $parameters));
	}
	
	public function setSystemClassProperty($sid, $className, $propertyName, $parameters = '') {
		$this->_post('system/'.$sid.'/class/'.$className.'/set/'.$propertyName, array('param' => $parameters));
	}
	
	public function getSystemClassProperty($sid, $className, $propertyName, $parameters = '') {
		$this->_post('system/'.$sid.'/class/'.$className.'/get/'.$propertyName, array('param' => $parameters));
	}
}

?>