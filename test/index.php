<?php
ini_set('display_errors', 'on');
error_reporting(E_ALL);
require_once __DIR__ . '/../vendor/autoload.php';

use W6\Tools\ErrorAgent;

include 'config.php';
$__agentConfig = $config;

$__agentConfig['sitename'] = 'Teste Agent';
$__agentConfig['from'] = array('rubens@websix.com.br' => 'ErrorAgent');
$__agentConfig['to'] = array('rubens@websix.com.br' => 'Rubens');
$__agentConfig['sendEmail'] = true;

new ErrorAgent();
include 'c.php';
//echo $__agentConfig['teste Error'];//erro pq a posição do array nao existe
//throw new \Exception('teste Exception');//teste
$c = new C;
$c->teste();
