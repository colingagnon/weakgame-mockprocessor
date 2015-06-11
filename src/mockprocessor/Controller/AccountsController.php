<?php

namespace MockProcessor\Controller;

class AccountsController extends ControllerAbstract
{
	// Gets all accounts
	public function getAccounts() {
		$this->success($this->select('SELECT * FROM `accounts`'));
	}

	// Get a single account by email
	public function getAccount($email) {
		$data = array('email' => $email);
		
		$result = $this->select('SELECT * FROM `accounts` WHERE `email` = :email', $data);
		
		if (count($result) > 0) {
			$this->success($result);			
		} else {
			$this->fail('Could not find account for: ' . $email);
		}
	}
	
	// Create a new account by email
	public function postAccount() {
		$data = $this->app->request()->post();
		
		if (empty($data['email']) === true) {
			$this->fail('No email provided for account.');
		}
		
		// Get account information
		$exists = $this->get('/accounts/' . $data['email']);
		if ($exists['status'] === 'success') {
			$this->fail('Account already exists for email: ' . $data['email']);
		}
		
		// Proceed with creation
		$data['createdOn'] = date('Y-m-d H:i:s');
		
		$sql  = 'INSERT INTO `accounts` (`email`, `createdOn`) ';
		$sql .= 'VALUES (:email, :createdOn)';
		$this->save($sql, $data);
		
		$this->success(array());
	}
	
	// Updates an account's information, only increase limit
	public function putAccount($email) {
		$data = $this->app->request()->post();
		if (empty($data['accountLimit']) === true) {
			$this->fail('You must specify an account limit.');
		}
		
		// Arbitrary accountLimit
		$limit = 50000;
		if ($data['accountLimit'] > $limit) {
			$this->fail('You cannot have an account limit over ' . $limit);
		}

		$sql  = 'UPDATE `accounts` SET accountLimit = :accountLimit ';
		$sql .= 'WHERE email = :email';
		$this->save($sql, array('accountLimit' => $data['accountLimit'], 'email' => $email));
		
		$this->success(array());
	}
}