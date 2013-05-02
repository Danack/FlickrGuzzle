<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class MethodError {

	use DataMapper{
		createFromJson as createFromJsonAuto;
	}

	static protected $dataMap = array(
		['code', 'code'],
		['message', 'message'],
		['fullText', '_content'],
	);

	var $code;
	var $message;
	var $fullText;
}




?>