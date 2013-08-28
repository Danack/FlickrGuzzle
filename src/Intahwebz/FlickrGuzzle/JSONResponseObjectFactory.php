<?php

namespace Intahwebz\FlickrGuzzle;

use Guzzle\Service\Command\OperationCommand;
//use Guzzle\Service\Command\AbstractCommand;

class JSONResponseObjectFactory extends AbstractResponseObjectFactory {

	public static $aliasedResponses = array(
		'Intahwebz\FlickrGuzzle\DTO\CameraBrandList' => 'brands',
		'Intahwebz\FlickrGuzzle\DTO\CameraDetailList' => 'cameras',
		'Intahwebz\FlickrGuzzle\DTO\PhotoList' => 'photos',
		//"Intahwebz\\FlickrGuzzle\\DTO\\Photo' => NULL,
		'Intahwebz\FlickrGuzzle\DTO\PhotoInfo'       => 'photo',
		'Intahwebz\FlickrGuzzle\DTO\OauthCheck' => 'oauth',
		//"Intahwebz\\FlickrGuzzle\\DTO\\MethodInfo' => NULL,
		'Intahwebz\FlickrGuzzle\DTO\MethodList'      => 'methods',
		'Intahwebz\FlickrGuzzle\DTO\InstitutionList' => 'institutions',
		//"Intahwebz\\FlickrGuzzle\\DTO\\LicenseList' => NULL,
		'Intahwebz\FlickrGuzzle\DTO\ActivityInfo"'   => 'items',
		'Intahwebz\FlickrGuzzle\DTO\PhotoInfoTransform"' => 'photoid',
		'Intahwebz\FlickrGuzzle\DTO\NoteID' => 'note',
		'Intahwebz\FlickrGuzzle\DTO\LookupUser' => 'user',
		'Intahwebz\FlickrGuzzle\DTO\LookupGroup' => 'group',
		'Intahwebz\FlickrGuzzle\DTO\LookupGallery' => 'gallery',
		//"Intahwebz\\FlickrGuzzle\\DTO\\URLInfo" => NULL,
		'Intahwebz\FlickrGuzzle\DTO\TagList'         => array('photo', 'who', 'hottags'), 		'Intahwebz\FlickrGuzzle\DTO\PlaceList' => 'places',
		'Intahwebz\FlickrGuzzle\DTO\UserBlogList' => 'blogs',
		'Intahwebz\FlickrGuzzle\DTO\BlogServiceList' => 'services',
		//"Intahwebz\\FlickrGuzzle\\DTO\\GenericResponse' => NULL,
		'Intahwebz\FlickrGuzzle\DTO\UserList'        => array('contacts'),
		//Intahwebz\FlickrGuzzle\DTO\AccountStat
	);

	/**
	 * Creates domain objects from the response.
	 *
	 * @param $className
	 * @param OperationCommand $command
	 */
	public static function fromCommand(OperationCommand $command) {

		$className = $command->getOperation()->getResponseClass();
		$data = $command->getRequest()->getResponse()->getBody(true);

		$decodedData = json_decode($data, true);

		self::checkErrorResponseFromJSON($decodedData);

		$decodedData = self::unaliasData($className, $decodedData);

		if ($decodedData == false) {
			throw new FlickrGuzzleException("Failed to extract data from returned response. Please check the alias that is meant to point to the data.");
		}

		$object = $className::createFromJson($decodedData);

		if ($object == false) {
			//TODO - this is for development only.
//				var_dump($data);
			throw new FlickrGuzzleException("Failed to create object $className - or possibly just failed to return the object from the createFromJson function.");
		}

		return $object;
	}

	/**
	 * The data returned from the flickr API either be at the top level or it can be
	 * encapsulatied e.g. $data['tags'] = [array of data] or $data  = [array of data]
	 *
	 * @param $className
	 * @param $dataJson
	 * @return mixed
	 */
	static function unaliasData($className, $dataJson) {
		if (array_key_exists($className, self::$aliasedResponses) == false) {
			return $dataJson;
		}

		$alias = self::$aliasedResponses[$className];

		if (is_array($alias) == false) {
			$alias = array($alias);
		}

		$aliasedData = $dataJson;

		foreach ($alias as $aliasElement) {
			if (array_key_exists($aliasElement, $dataJson)) {
				$aliasedData = $dataJson[$aliasElement];
				break; //We found the data, stop searching.
			}
		}

		return $aliasedData;
	}

	/**
	 * Check whether stat is set in an JSON response and whether it is 'ok'. if not generate a FlickrAPIException through processErrorResponse
	 * The Flickr API (generally) doesn't give HTTP error codes. Instead it just sets an appropriate 'stat' code.
	 * @param $parsedResponse
	 */
	static function    checkErrorResponseFromJSON($dataJson) {
		if (array_key_exists('stat', $dataJson) == true && $dataJson['stat'] != 'ok') {

			$errorCode = 0;
			$flickrMessage = null;
			if (array_key_exists('code', $dataJson)) {
				$errorCode = $dataJson['code'];
			}

			if (array_key_exists('message', $dataJson)) {
				$flickrMessage = $dataJson['message'];
			}

			self::processErrorResponse($errorCode, $flickrMessage);
		}
	}

}

