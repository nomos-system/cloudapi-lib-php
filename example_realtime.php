<?php

include_once 'realtime/client.php';

$client = RealtimeClient::connect('ACCESS_TOKEN', 'CLIENT_ID');

if($client !== false) {
	$client->emit('getUser');
	$data = $client->getResult(2000);
	var_dump($data);
	
	$client->emit('getSystem', ['sid' => 'NS3XTNBOXR2V']);
	$data = $client->getResult(5000);
	var_dump($data);
	
	$client->close();
}
else {
	echo "Can't establish connection!\n";
}

?>