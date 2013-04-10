<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class MethodInfo {

	use DataMapper{
		createFromData as createFromDataAuto;
	}

	static protected $dataMap = array(
		['name', ['method', 'name']],
		['needsLogin', ['method', 'needslogin']],

		['needsSigning', ['method', 'needssigning']],
		['requiredPerms', ['method', 'requiredperms']],

		['description', ['method', 'description']],

		['response', ['method', 'response'], 'optional' => TRUE],

		['arguments', ['arguments', 'argument'], 'class' => 'Intahwebz\\FlickrAPI\\DTO\\MethodArgument', 'multiple' => TRUE ],
		['errors', ['errors', 'error'], 'class' => 'Intahwebz\\FlickrAPI\\DTO\\MethodError', 'multiple' => TRUE ],
	);

	var	$name;
	var $needsLogin;
	var $needsSigning;
	var $requiredPerms;

	var $description;
	var $response = NULL;

	/** @var MethodArgument[] */
	var $arguments = array();
	var $errors = array();


	static function createFromData($data){
		$object = self::createFromDataAuto($data);

		$remap = array(
			'description',
			'response',
		);

		$object->remap($remap, '_content');

		return $object;
	}
}

?>