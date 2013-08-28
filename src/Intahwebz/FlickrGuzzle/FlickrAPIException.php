<?php


namespace Intahwebz\FlickrGuzzle;


class FlickrAPIException extends \Exception {

	var $errorCode;
	var $flickrMessage;

	public function		__construct(
			$errorCode,
			$flickrMessage,
			$message = "",
			$code = 0,
			\Exception $previous = null){

		parent::__construct($message, $code, $previous);

		$this->errorCode = $errorCode;
		$this->flickrMessage = $flickrMessage;
	}
}

