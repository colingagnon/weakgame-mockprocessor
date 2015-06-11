<?php

namespace MockProcessor\Controller;

class TransactionsController extends ControllerAbstract
{
	// Gets all transactions
	function getTransactions() {
		$this->success($this->select('SELECT * FROM `transactions`'));
	}
	
	// Gets a single transaction by id
	function getTransaction($id) {
		$data = array('id' => $id);
		
		$result = $this->select('SELECT * FROM `transactions` WHERE `id` = :id', $data);
		
		if (count($result) > 0) {
			$this->success($result);			
		} else {
			$this->fail('Could not find transaction id : ' . $id);
		}
	}
	
	// Creates a new transaction
	function postTransaction() {
		$data = $this->app->request()->post();
		
		if (empty($data['email']) === true) {
			$this->fail('No email provided for account.');
		}
		
		if (empty($data['amount']) === true) {
			$this->fail('No amount provided for transaction.');
		}
		
		// Get account information
		$accountData = $this->get('/accounts/' . $data['email']);
		if ($accountData['status'] === 'fail') {
			$this->fail('Could not find account for email: ' . $data['email']);
		}
		
		// Set reference to row
		$account = $accountData['data'][0];

		// Make sure this account isn't maxed out
		$newBalance = $account['accountBalance'] + $data['amount'];
		if ($newBalance > $account['accountLimit']) {
			$this->fail('Transaction over account limit of ' . $account['accountLimit']);
		}
		
		// Proceed with creation of transaction
		$queryData['accountId'] = $account['id'];
		$queryData['amount']    = $data['amount'];
		$queryData['createdOn'] = date('Y-m-d H:i:s');

		$sql  = 'INSERT INTO `transactions` (`accountId`, `amount`, `createdOn`) ';
		$sql .= 'VALUES (:accountId, :amount, :createdOn)';
		$this->save($sql, $queryData);
		
		// Update accountBalance with new amount
		$sql  = 'UPDATE `accounts` SET accountBalance = :accountBalance ';
		$sql .= 'WHERE email = :email';
		$this->save($sql, array('accountBalance' => $newBalance, 'email' => $data['email']));
		
		$this->success(array());
	}
	
}