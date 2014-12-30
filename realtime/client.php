<?php

include_once 'vendor/autoload.php';

use ElephantIO\Client,
	ElephantIO\Engine\SocketIO\Version1X;

class RealtimeClient {
	
	public static function connect($accessToken, $clientId) {
		try {
			$client = new Client(new Version1X('https://cloudapi-01.nomos-system.com:443?'.http_build_query(array('access_token' => $accessToken, 'client' => $clientId)), '/control', array('version' => 3)));
			$client->initialize();
			return $client;
		}
		catch (Exception $e) {
			return false;
		}
	}
}

?>