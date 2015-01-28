<?php

if(!function_exists('build_http_query')){
	function build_http_query( $query ){
		$query_array = array();
		foreach( $query as $key => $key_value ){
			$query_array[] = urlencode( $key ) . '=' . urlencode( $key_value );
		}
		return implode( '&', $query_array );
	}
}

class elastic_wrapper {
	public $endpoint = 'ssl://api.elasticemail.com';
	public $apikey;

	function __construct($apikey=null){
		if(is_null($apikey))return error('API key required in __construct(apikey)');
		$this->apikey = $apikey;
	}
	function send($params=array()){
		if(empty($params))return $this->error('Params required in send([to=>to, from=>from, subject=>subject, body_html=>body_html])');
		$params['body_html'] = urlencode($params['body_html']);
		$params['apikey'] = $this->apikey;
		$data = build_http_query($params);
		$header = "POST /mailer/send HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($data) . "\r\n\r\n";
		$res = '';
		$fp = fsockopen('ssl://api.elasticemail.com', 443, $errno, $errstr, 30);
		if(!$fp)return $this->error('Could not open connection');
		fputs($fp, $header.$data);
		while(!feof($fp)) {
			$res .= fread($fp, 1024);
		}
		fclose($fp);
		return $res;
	}
	function error($msg=''){
		echo $msg;
		return false;
	}
}

?>
