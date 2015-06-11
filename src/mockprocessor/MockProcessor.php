<?php

namespace MockProcessor;

use \MockProcessor\Controller\IndexController;
use \MockProcessor\Middleware\Auth;

class MockProcessor
{
	private $app;
	
	function __construct($dbh, $env) {
		$this->app = new \Slim\Slim(array(
				'mode' => $env
				/*
				'log.enabled' => true,
				'log.level' => SlimLog::DEBUG,
				'log.writer' => new APILogWriter()
				*/
		));
		
		// TODO Should probably inject this a proper way at some point
		$this->app->dbh = $dbh;
		
		// Return some api documentation
		$this->app->get ('/', 'MockProcessor\Controller\IndexController:index');
		
		// Accounts
		$this->app->get ('/accounts', 'MockProcessor\Controller\AccountsController:getAccounts');
		$this->app->get ('/accounts/:email', 'MockProcessor\Controller\AccountsController:getAccount');
		
		$this->app->post('/accounts', 'MockProcessor\Controller\AccountsController:postAccount');
		$this->app->put ('/accounts/:email', 'MockProcessor\Controller\AccountsController:putAccount');
		
		// Transactions
		$this->app->get ('/transactions', 'MockProcessor\Controller\TransactionsController:getTransactions');
		$this->app->get ('/transactions/:id', 'MockProcessor\Controller\TransactionsController:getTransaction');
		
		$this->app->post('/transactions', 'MockProcessor\Controller\TransactionsController:postTransaction');
		
		// Middleware
		//$this->app->add(new Auth());
	}
	
	public function run() {
		$this->app->run();
	}
}
