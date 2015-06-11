<?php 
// Include our composer autoloader
$loader = require(realpath(__DIR__) . '/../vendor/autoload.php');

// Handle some setup crap
$env = getenv('APPLICATION_ENV');

if (empty($env) === true) {
	$env = 'production';
}

if ($env === 'development') {
	$username = 'root';
	$password = 'maxx';
} else {
	$username = 'mockprocessor';
	$password = 'omgsosecretpass';
}

// Setup PDO connection
$dsn = 'mysql:host=localhost;dbname=mockprocessor';
$options = array(
		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);
$dbh = new PDO($dsn, $username, $password, $options);

// Build our API application
$mock = new \MockProcessor\MockProcessor($dbh, $env);

// Allow CORS
header('Access-Control-Allow-Origin: *');

// Now run application
$mock->run();
