<?php
namespace MockProcessor\Middleware;

use \Slim\Middleware;
use \MockProcessor\Helper\Json;

class Auth extends Middleware
{
    public function call() {
        $req = $this->app->request();
        $get = $req->get();
        
        $res = $this->app->response();

        // Check if username and password sent
        if (empty($get['username']) === true || empty($get['password']) === true) {
        	Json::error($res, 'You must pass authentication credentials in GET: username=user&password=pass');
        	return;
        }
        
        if ($get['username'] !== 'weakgameadmin' && $get['password'] !== '$$92@best@REST@month@49$$') {
        	Json::fail($res, 'Invalid username and password.');
        	return;
        }
        
        // Proceed with api call
        $this->next->call();
    }
}
