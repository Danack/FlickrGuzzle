<?php


namespace Intahwebz\FlickrGuzzle;

use Intahwebz\FlickrGuzzle\DTO\OauthAccessToken;
use Intahwebz\FlickrGuzzle\FlickrAPIException;

use Guzzle\Common\Collection;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;
use Guzzle\Http\Exception;

use Guzzle\Service\Command\OperationCommand;

use         Guzzle\Service\Command\CreateResponseClassEvent;



class FlickrGuzzleClient extends Client{


	const PLACE_TYPE_NEIGHBOURHOOD = 22;
	const PLACE_TYPE_LOCALITY = 7;
	const PLACE_TYPE_REGION = 8;
	const PLACE_TYPE_COUNTRY = 12;
	const PLACE_TYPE_CONTINENT = 29;

    function parseClass(CreateResponseClassEvent $event) {

        $command = $event->offsetGet('command');
        $object = null;

        switch($command->getName()){
            case('GetOauthRequestToken'):
            case('GetOauthAccessToken'):{
                $object = KeyValueResponseObjectFactory::fromCommand($command);
                break;
            }

            //ReplacePhoto also?
            case('UploadPhoto'):{
                $object = XMLResponseObjectFactory::fromCommand($command);
                break;
            }

            default:{
                $object = JSONResponseObjectFactory::fromCommand($command);
                break;
            }
        }

        if ($object != null) {
            $event->setResult($object);
        }
    }


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
	 * @param $command
	 * @return mixed
	 */
	public static function factoryWithCommand($command, $config = array()){
		$client = self::factory($config);
		return $client->getCommandAndExecute($command);
	}

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
	 * @return FlickrGuzzleClient
	 */
	public static function factory($config = array()) {
		if ($config instanceof OauthAccessToken) {
			$oauthAccessToken = $config;
			$config = array(
				'oauth' => TRUE,
				'token' => $oauthAccessToken->oauthToken,
				'token_secret' => $oauthAccessToken->oauthTokenSecret,

			);
		}
		else if ($config === FALSE) {
			$config = array();
		}
		else if ($config === TRUE) {
			$config = array(
				'oauth' => TRUE,
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

        $client->getEventDispatcher()->addListener('command.parse_response', [$client, 'parseClass']);
        return $client;
	}

	/**
	 * The data returned from the flickr API is always encapsulated at the top level
	 *
	 * @param $className
	 * @param $dataJson
	 * @return mixed
	 */
	function unaliasData($className, $dataJson){
		if (array_key_exists($className, $this->aliasedResponses) == FALSE) {
			return $dataJson;
		}

		$alias = $this->aliasedResponses[$className];

		if (is_array($alias) == FALSE) {
			$alias = array($alias);
		}

		$aliasedData = $dataJson;

		foreach ($alias as $aliasElement) {
			if (array_key_exists($aliasElement, $dataJson) ){
				$aliasedData = $dataJson[$aliasElement];
				break;//We found the data, stop searching.
			}
		}

		return $aliasedData;
	}


	/**
	 * Check whether stat is set in an JSON response and whether it is 'ok'. if not generate a FlickrAPIException through processErrorResponse
	 * The Flickr API (generally) doesn't give HTTP error codes. Instead it just sets an appropriate 'stat' code.
	 * @param $parsedResponse
	 */
	function	checkErrorResponseFromJSON($dataJson){
		if (array_key_exists('stat', $dataJson) == TRUE &&
			$dataJson['stat'] != 'ok') {

			$errorCode = 0;
			$flickrMessage = NULL;
			if (array_key_exists('code', $dataJson)) {
				$errorCode = $dataJson['code'];
			}

			if (array_key_exists('message', $dataJson)) {
				$flickrMessage = $dataJson['message'];
			}

			$this->processErrorResponse($errorCode, $flickrMessage);
		}
	}

	/**
	 * Check whether stat is set in an XML response and whether it is 'ok'. if not generate a FlickrAPIException through processErrorResponse
	 * The Flickr API (generally) doesn't give HTTP error codes. Instead it just sets an appropriate 'stat' code.
	 * @param $parsedResponse
	 */
	function checkErrorResponseFromXML($parsedResponse) {
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

			$this->processErrorResponse($errorCode, $message);
		}
	}

	/**
	 * @param $errorCode
	 * @param null $message
	 * @throws FlickrAPIException
	 */
	function	processErrorResponse($errorCode, $message = NULL){
		if ($message == NULL) {
			$message = 'No message set.';
		}

		$errorMeaning = "Unknown error code '$errorCode': '$message' ";

		if (array_key_exists($errorCode, self::$knownErrorCodes)) {
			$errorMeaning = self::$knownErrorCodes[$errorCode];
		}

		throw new FlickrAPIException($errorCode, $message, "Exception calling flickr API: ".$errorMeaning);
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
	private function getResponseFromXML($xml){
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
	 * Calculate how many of the entries in the Service description have been implemented.
	 * This is only used for making progress reports.
	 * @return array
	 */
	static function getAPIProgress(){
		$serviceDescription = include __DIR__ . '/service.php';

		$operationCount = 0;
		$operationWithResponseClassCount = 0;

		$functionsLeftToImplement = array();

		foreach($serviceDescription['operations'] as $operationName => $operation) {
			if ($operationName != 'defaultGetOperation') {
				$operationCount++;
				if (array_key_exists('responseClass', $operation) == TRUE) {
					if ($operation['responseClass'] != NULL) {
						$operationWithResponseClassCount++;

						$functionsWithResponseClasses[$operationName] = $operation['responseClass'];
					}
					else{
						$functionsLeftToImplement[] = $operationName;
					}
				}
			}
		}

		$result = array(
			'operationCount' => $operationCount,
			'operationWithResponseClassCount' => $operationWithResponseClassCount,
			'functionsLeftToImplement' => $functionsLeftToImplement,
			'functionsWithResponseClasses' => $functionsWithResponseClasses,
		);

		return $result;
	}

	/**
	 * Get and execute a command in one function. Allows return type hinting.
	 * http://confluence.jetbrains.com/display/PhpStorm/PhpStorm+Advanced+Metadata
	 * @param $name
	 * @param array $args
	 * @return mixed
	 */
	public function getCommandAndExecute($name, array $args = array()) {
		$command = $this->getCommand($name, $args);
		$object = $command->execute();
		return $object;
	}
}


?>