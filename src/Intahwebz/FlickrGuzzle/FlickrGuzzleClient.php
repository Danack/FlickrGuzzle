<?php


namespace Intahwebz\FlickrGuzzle;

use Intahwebz\FlickrGuzzle\DTO\OauthAccessToken;
use Intahwebz\FlickrGuzzle\FlickrAPIException;

use Guzzle\Common\Collection;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;
use Guzzle\Http\Exception;

use Guzzle\Service\Command\AbstractCommand;

class FlickrGuzzleClient extends Client{

	const PLACE_TYPE_NEIGHBOURHOOD = 22;
	const PLACE_TYPE_LOCALITY = 7;
	const PLACE_TYPE_REGION = 8;
	const PLACE_TYPE_COUNTRY = 12;
	const PLACE_TYPE_CONTINENT = 29;

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

		return $client;
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
}




?>