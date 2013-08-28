<?php


namespace Intahwebz\FlickrGuzzle;

use Guzzle\Service\Command\OperationCommand;

class XMLResponseObjectFactory extends AbstractResponseObjectFactory {

	/**
	 * Creates domain objects from the response.
	 *
	 * @param $className
	 * @param OperationCommand $command
	 */
	public static function fromCommand(OperationCommand $command){

		$className = $command->getOperation()->getResponseClass();
		$data = $command->getRequest()->getResponse()->getBody(TRUE);

		return self::parseXMLResponse($data, $className);

		$object = $className::createFromJson($decodedData);

		if ($object == FALSE) {
			//TODO - this is for development only.
//				var_dump($data);
			throw new FlickrGuzzleException("Failed to create object $className - or possibly just failed to return the object from the createFromJson function.");
		}

		return $object;
	}


	/**
	 * Parse an XML resonse. The Flickr API is hard-coded to return XML for some functions :P
	 *
	 * @param $data
	 * @param $className
	 * @return mixed
	 */
	static function parseXMLResponse($data, $className) {
		//Wtf is this?
		//oh - this function call always returns 'xml' even if you request JSON.
//				xml version="1.0" encoding="utf-8"
//			<rsp stat="ok">
//				<photoid>8636447595</photoid>
//			</rsp>
		$parsedResponse = self::getResponseFromXML($data);

		self::checkErrorResponseFromXML($parsedResponse);
		return $className::createFromJson($parsedResponse);
	}

	/**
	 * Get the response structure from an XML response.
	 * Annoyingly, upload and replace returns XML rather than serialised PHP.
	 * The responses are pretty simple, so rather than depend on an XML parser we'll fake it and
	 * decode using regexps
	 * @param $xml
	 * @return mixed
	 *
	 * Taken from https://github.com/dopiaza/DPZFlickr
	 */
	static function getResponseFromXML($xml){
		$rsp = array();
		$stat = 'fail';
		$matches = array();
		preg_match('/<rsp stat="(ok|fail)">/s', $xml, $matches);
		if (count($matches) > 0)
		{
			$stat = $matches[1];
		}
		if ($stat == 'ok')
		{
			// do this in individual steps in case the order of the attributes ever changes
			$rsp['stat'] = $stat;
			$photoid = array();
			$matches = array();
			preg_match('/<photoid.*>(\d+)<\/photoid>/s', $xml, $matches);
			if (count($matches) > 0)
			{
				$photoid['_content'] = $matches[1];
			}
			$matches = array();
			preg_match('/<photoid.* secret="(\w+)".*>/s', $xml, $matches);
			if (count($matches) > 0)
			{
				$photoid['secret'] = $matches[1];
			}
			$matches = array();
			preg_match('/<photoid.* originalsecret="(\w+)".*>/s', $xml, $matches);
			if (count($matches) > 0)
			{
				$photoid['originalsecret'] = $matches[1];
			}
			$rsp['photoid'] = $photoid;
		}
		else
		{
			$rsp['stat'] = 'fail';
			$err = array();
			$matches = array();
			preg_match('/<err.* code="([^"]*)".*>/s', $xml, $matches);
			if (count($matches) > 0)
			{
				$err['code'] = $matches[1];
			}
			$matches = array();
			preg_match('/<err.* msg="([^"]*)".*>/s', $xml, $matches);
			if (count($matches) > 0)
			{
				$err['msg'] = $matches[1];
			}
			$rsp['err'] = $err;
		}
		return $rsp;
	}


	/**
	 * Check whether stat is set in an XML response and whether it is 'ok'. if not generate a FlickrAPIException through processErrorResponse
	 * The Flickr API (generally) doesn't give HTTP error codes. Instead it just sets an appropriate 'stat' code.
	 * @param $parsedResponse
	 */
	static function checkErrorResponseFromXML($parsedResponse) {
		if (array_key_exists('stat', $parsedResponse) == TRUE &&
			$parsedResponse['stat'] != 'ok') {

			$errorCode = 0;
			$message = NULL;

			if (isset($parsedResponse['err']['code']) == TRUE) {
				$errorCode = $parsedResponse['err']['code'];
			}

			if (isset($parsedResponse['err']['msg']) == TRUE) {
				$message = $parsedResponse['err']['msg'];
			}

			self::processErrorResponse($errorCode, $message);
		}
	}

}

