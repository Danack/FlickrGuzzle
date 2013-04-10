<?php


namespace Intahwebz\FlickrAPI;

use Intahwebz\FlickrAPI\DTO\OauthAccessToken;

use Guzzle\Common\Collection;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;
use Guzzle\Http\Exception;

use Guzzle\Service\Command\OperationCommand;

class FlickrAPIClient extends Client{

	/**
	 * Factory method to create a new FlickrAPIClient
	 *
	 * The following array keys and values are available options:
	 * - base_url: Base URL of web service
	 * - scheme:   URI scheme: http or https
	 * - username: API username
	 * - password: API password
	 *
	 * @param array|Collection $config Configuration data
	 *
	 * @return self
	 */
	public static function factory($config = array())
	{
		if ($config instanceof OauthAccessToken) {
			$oauthAccessToken = $config;
			$config = array(
				'oauth' => true,
				'token' => $oauthAccessToken->oauthToken,
				'token_secret' => $oauthAccessToken->oauthTokenSecret,

			);
		}
		else if ($config === false) {
			$config = array();
		}
		else if ($config === true) {
			$config = array(
				'oauth' => true,
			);
		}

		$default = array(
			'base_url'	=> '{scheme}://http://api.flickr.com/services/rest',
			'scheme'	=> 'http',
		);
		$required = array();//'username', 'password', 'base_url');
		$collectedConfig = Collection::fromConfig($config, $default, $required);

		$client = new self($collectedConfig->get('base_url'), $config);
		// Attach a service description to the client
		$description = ServiceDescription::factory(__DIR__ . '/service.php');
		$client->setDescription($description);

		if (array_key_exists('oauth', $config) && $config['oauth']) {
			$params = array(
				'consumer_key'    => FLICKR_KEY,
				'consumer_secret' => FLICKR_SECRET,
			);

			if(array_key_exists('token', $config)){
				$params['token'] = $config['token'];
			}

			if(array_key_exists('token_secret', $config)){
				$params['token_secret'] = $config['token_secret'];
			}

			$oauth = new FlickrOauthPlugin($params);
			$client->addSubscriber($oauth);
		}

		return $client;
	}


//	public function getCommand($name, array $args = array()) {
//		$command = parent::getCommand($name, $args);
//
//		if ($this->oauthToken != null) {
//			$command->add('oauth_token', $this->oauthToken);
//		}
//
//		return $command;
//	}

	/**
	 * Creates DTO objects from the response.
	 *
	 * @param $className
	 * @param OperationCommand $command
	 */
	public function createObject($className, OperationCommand  $command){
		$data = $command->getRequest()->getResponse()->getBody(TRUE);

		$xmlResponses = array(
			"Intahwebz\\FlickrAPI\\DTO\\FileUploadResponse"
		);

		if (in_array($className, $xmlResponses) == TRUE) {

			//Wtf is this shit.
//				xml version="1.0" encoding="utf-8"
//			<rsp stat="ok">
//				<photoid>8636447595</photoid>
//			</rsp>
			$parsedResponse = $this->getResponseFromXML($data);

//			var_dump($parsedResponse);

			return $className::createFromData($parsedResponse);
		}

		$hilariousNonStandardResponses = array(
			'Intahwebz\\FlickrAPI\\DTO\\OauthAccessToken',
			'Intahwebz\\FlickrAPI\\DTO\\OauthRequestToken',
		);

		if (in_array($className, $hilariousNonStandardResponses) == TRUE) {
			$params = splitParameters($data);
			//var_dump($data);
			return $className::createFromData($params);
		}

		$aliasedResponses = array(
			'Intahwebz\\FlickrAPI\\DTO\\CameraBrandList' => 'brands',
			"Intahwebz\\FlickrAPI\\DTO\\CameraDetailList" => 'cameras',
			"Intahwebz\\FlickrAPI\\DTO\\PhotoList" => 'photos',
			"Intahwebz\\FlickrAPI\\DTO\\Photo" => NULL,
			"Intahwebz\\FlickrAPI\\DTO\\PhotoInfo" => 'photo',
			"Intahwebz\\FlickrAPI\\DTO\\OauthCheck" => 'oauth',
		);

		if (array_key_exists($className, $aliasedResponses) == TRUE) {
			$dataJson = json_decode($data, TRUE);
			if (array_key_exists('stat', $dataJson) == TRUE &&
				$dataJson['stat'] != 'ok') {
				$this->processErrorResponse($dataJson);
			}

			$alias = $aliasedResponses[$className];
			if ($alias != NULL) {
				$aliasedData = $dataJson[$alias];
			}
			else{
				$aliasedData = $dataJson;
			}

			$object = $className::createFromData($aliasedData);

			if ($object == FALSE) {
				throw new \Exception("Failed to create object $className - or possibly just failed to return the object from the createFromData function.");
			}

			return $object;
		}

		echo "Ooops classname [".$className."] is not mapped";
		echo "Json was:<br/>";
		var_dump($data);
		exit(0);
	}

	function getFlickrImageURL($imageInfo){
		$farmID = $imageInfo['farm'];
		$serverID = $imageInfo['server'];
		$id = $imageInfo['id'];
		$secret = $imageInfo['secret'];
		$size = 'q';

		return "http://farm".$farmID.".staticflickr.com/".$serverID."/${id}_${secret}_${size}.jpg";
	}


	function getPhotoInfo($photoID, $secret = FALSE){
		$params = array(
			'method'    => 'flickr.photos.getInfo',
			'api_key' => FLICKR_KEY,// (Required) Your API application key. See here for more details.
			'photo_id' => $photoID, // (Required) The id of the photo to get information for.
			'format' => 'json',
			'nojsoncallback' => 1,
		);

		if($secret !== FALSE){
			$params['secret'] = $secret; // (Optional) - skips auth check if set.
		}

		$client = new Client('http://api.flickr.com/services/rest/');
		$request = $client->get();
		$request->getQuery()->merge($params);

		$response = $request->send();

		$data = $response->json();

		$photoInfo = PhotoInfo::createFromData($data['photo']);

		return $photoInfo;
	}


	function	removeTag(){

		//	api_key (Required)
		//Your API application key. See here for more details.
		//	tag_id (Required)
		//	The tag to remove from the photo.

	}

	function	processErrorResponse($dataJson){
		$errorCode = 0;
		$flickrReason = "Not set.";

		if (array_key_exists('code', $dataJson)) {
			$errorCode = $dataJson['code'];
		}

		if (array_key_exists('message', $dataJson)) {
			$flickrMessage = $dataJson['message'];
		}

		$knownErrorCodes = array(
			1 => 'Required arguments missing',

			//1: Photo not found

			2 => 'Maximum number of tags reached',

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

		$errorMeaning = "Unknown error code '$errorCode': '$flickrMessage' ";

		if (in_array($errorCode, $knownErrorCodes)) {
			$errorMeaning = $knownErrorCodes[$errorCode];
		}

		throw new FlickrAPIException($errorCode, $flickrMessage, "Exception calling flickr API: ".$errorMeaning);
	}



	/**
	 * Get the response structure from an XML response.
	 * Annoyingly, upload and replace returns XML rather than serialised PHP.
	 * The responses are pretty simple, so rather than depend on an XML parser we'll fake it and
	 * decode using regexps
	 * @param $xml
	 * @return mixed
	 *
	 *
	 * Taken from https://github.com/dopiaza/DPZFlickr
	 */
	private function getResponseFromXML($xml)
	{
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

}


function splitParameters($string){

	//Taken from
	//https://github.com/dopiaza/DPZFlickr/blob/master/README.md
	//This function is MIT licensed

	$parameters = array();
	$keyValuePairs = explode('&', $string);
	foreach ($keyValuePairs as $kvp)	{
		$pieces = explode('=', $kvp);
		if (count($pieces) == 2)		{
			$parameters[rawurldecode($pieces[0])] = rawurldecode($pieces[1]);
		}
	}
	return $parameters;
}


?>