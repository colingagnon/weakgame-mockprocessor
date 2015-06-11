<?php

namespace MockProcessor\Controller;

use Slim\Slim;

class IndexController extends ControllerAbstract
{
	public function index () {
		//$api = Slim::getInstance();
		echo '<h2><strong>Mock Processor</strong></h2>';
		echo '<p>Welcome to the worst API documentation ever.</p>';
		
		//$get['username'] !== 'weakgameadmin' && $get['password'] !== '$$92@best@REST@month@49$$'
		
		echo '<br /><h3><strong>Accounts</strong></h3>';
		
		echo '<h5>Get all accounts</h5>';
		echo 'GET :: /accounts<br />';
		
		echo '<h5>Get account by email</h5>';
		echo 'GET :: /accounts/:email<br />';
		
		echo '<h5>Create new account</h5>';
		echo 'POST :: /accounts {email} <br />';
		
		echo '<h5>Update account information</h5>';
		echo 'PUT :: /accounts {accountLimit: 50000} <br />';
		
		echo '<br /><h3><strong>Transactions</strong></h3>';
		
		echo '<h5>Get all transactions</h5>';
		echo 'GET :: /transactions<br />';
		
		echo '<h5>Get transaction by id</h5>';
		echo 'GET :: /transactions/:id<br />';
		
		echo '<h5>Create new transaction</h5>';
		echo 'GET :: /transactions {email, amount} <br />';
	}
}