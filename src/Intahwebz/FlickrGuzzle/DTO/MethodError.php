<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class MethodError {

	use DataMapper{
		createFromData as createFromDataAuto;
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