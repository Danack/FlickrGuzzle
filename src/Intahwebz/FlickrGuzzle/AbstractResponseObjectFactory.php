<?php


namespace Intahwebz\FlickrGuzzle;

use Guzzle\Service\Command\AbstractCommand;



abstract class AbstractResponseObjectFactory {

	abstract public static function factory(AbstractCommand $command);

	//The error codes are dependent on which function is being called :P
	//TODO Need to make a list of errors per function.
	static public $knownErrorCodes = array(
		1 => 'Required arguments missing',
		//1: Photo not found
		//1, "message":"User does not have stats"
		2 => 'Maximum number of tags reached',

		//Trying to favourite your own picture...
		//'stat' => string 'fail' (length=4)
		//'code' => int 2
		//'message' => string 'Photo is owned by you'
		96 => 'Invalid signature',
		97 => 'Missing signature',
		98 => 'Invalid auth token.',
		100 => 'Invalid API Key',
		105 => 'Service currently unavailable',
		111 => 'Format "xxx" not found',
		112 => 'Method "xxx" not found',
		114 => 'Invalid SOAP envelope',
		115 => 'Invalid XML-RPC Method',
		116 => 'Bad URL found',
	);

	/**
	 * @param $errorCode
	 * @param null $message
	 * @throws FlickrAPIException
	 */
	static function	processErrorResponse($errorCode, $message = NULL){
		if ($message == NULL) {
			$message = 'No message set.';
		}

		$errorMeaning = "Unknown error code '$errorCode': '$message' ";

		if (array_key_exists($errorCode, self::$knownErrorCodes)) {
			$errorMeaning = self::$knownErrorCodes[$errorCode];
		}

		throw new FlickrAPIException($errorCode, $message, "Exception calling flickr API: ".$errorMeaning);
	}

}



?>