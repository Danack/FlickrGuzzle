<?php


namespace Intahwebz\FlickrGuzzle;

//use Guzzle\Service\Command\AbstractCommand;
use Guzzle\Service\Command\OperationCommand;

class KeyValueResponseObjectFactory extends AbstractResponseObjectFactory {

	/**
	 * Creates domain objects from the response.
	 *
	 * @param $className
	 * @param OperationCommand $command
	 */
	public static function fromCommand(OperationCommand $command){
		$className = $command->getOperation()->getResponseClass();
		$data = $command->getRequest()->getResponse()->getBody(TRUE);
		$params = splitParameters($data);
		return $className::createFromJson($params);
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