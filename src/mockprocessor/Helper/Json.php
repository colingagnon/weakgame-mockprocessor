<?php 

namespace MockProcessor\Helper;

class Json {
	// Returns success response with data
	public static function success($res, $data) {
		self::respond($res, array('status' => 'success', 'data' => $data));
	}
	
	// Returns fail response with message
	public static function fail($res, $message) {
		self::respond($res, array('status' => 'fail', 'message' => $message));
	}

	// Returns error response with message
	public static function error($res, $message) {
		self::respond($res, array('status' => 'error', 'message' => $message));
	}
	
	// Actually handles response
	public static function respond($res, $body) {
		$res['Content-Type'] = 'application/json';
		$res->body(json_encode($body));
		return $res;
	}
}
