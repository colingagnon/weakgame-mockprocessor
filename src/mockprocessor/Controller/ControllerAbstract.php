<?php

namespace MockProcessor\Controller;

use \Slim\Slim;
use \MockProcessor\Helper\Db;
use \MockProcessor\Helper\Json;
use \GuzzleHttp\Client as Guzzle;


/*
$client = new GuzzleHttp\Client();
$response = $client->get('http://guzzlephp.org');
$res = $client->get('https://api.github.com/user', ['auth' =>  ['user', 'pass']]);
echo $res->getStatusCode();
// "200"
echo $res->getHeader('content-type');
// 'application/json; charset=utf8'
echo $res->getBody();
// {"type":"User"...'
var_export($res->json());
// Outputs the JSON decoded data

// Send an asynchronous request.
$req = $client->createRequest('GET', 'http://httpbin.org', ['future' => true]);
$client->send($req)->then(function ($response) {
	echo 'I completed! ' . $response;
});
*/

abstract class ControllerAbstract
{
	protected $app;
	protected $http;
	
	function __construct() {
		$this->app = Slim::getInstance();
		$this->http = new Guzzle();
	}
	
	// Gets a route of the api
	function get($route) {
		$uri = $this->app->request()->getHost() . $route;
		$res = $this->http->get($uri);

		try {
			return json_decode($res->getBody(), true);
		} catch (\Exception $e) {
			return null;
		}
	}
	
	// Selects data from db
	protected function select($sql, $data = array()) {
		try {
			return Db::select($this->app->dbh, $sql, $data);
		} catch (\Exception $e) {
			echo $e->getMessage();
		}
	}
	
	// Saves data to db
	protected function save($sql, $data = array()) {
		try {
			return Db::save($this->app->dbh, $sql, $data);
		} catch (\Exception $e) {
			echo $e->getMessage();
		}
	}
	
	// Returns success response with data
	protected function success($data) {
		try {
			Json::success($this->app->response(), $data);
		} catch (\Exception $e) {
			Json::error($e->getMessage());
		}
	}
	
	// Returns fail response with message
	protected function fail($message) {
		Json::fail($this->app->response(), $message);
		$this->app->stop();
	}

	// Returns error response with message
	protected function error($message) {
		Json::error($this->app->response(), $message);
		$this->app->stop();
	}
}
