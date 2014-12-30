<?php

include_once 'rest/client.php';

$accessToken = 'ACCESS_TOKEN';

// XML
$client = new RestClient($accessToken, RestClient::OUTPUT_FORMAT_XML);
$client->getSystems();
echo "\r\n";
$client->getSystemClassGetPropertiesCommands('NXS3E63FF30', 'sys');
echo "\r\n";
$client->setSystemClassProperty('NXS3E63FF30', 'sys', 'var', 'TestVar,1');
echo "\r\n";
$client->executeRaw('NXS3E63FF30', '{"version":1,"method":"command","class":"sys","command":[{"name":"hello","value":""}]}');

// JSON
$client = new RestClient($accessToken, RestClient::OUTPUT_FORMAT_JSON);
echo "\r\n\r\n";
$client->getUser();
echo "\r\n";
$client->getSystemClassValues('NXS3E63FF30', 'zwave');
echo "\r\n";
$client->executeSystemClassCommand('NXS3E63FF30', 'sys', 'hello');

// JSONP
$client = new RestClient($accessToken, RestClient::OUTPUT_FORMAT_JSONP, 'testFunctionName');
echo "\r\n\r\n";
$client->getSystem('NXS3E63FF30');
echo "\r\n";
$client->getSystemClassProperty('NXS3E63FF30', 'sys', 'date');

?>