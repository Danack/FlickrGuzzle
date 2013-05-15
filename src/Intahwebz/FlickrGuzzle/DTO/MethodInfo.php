<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class MethodInfo {

	use DataMapper;
//	{
//		createFromJson as createFromJsonAuto;
//	}

	static protected $dataMap = array(
		['name', ['method', 'name']],
		['needsLogin', ['method', 'needslogin']],

		['needsSigning', ['method', 'needssigning']],
		['requiredPerms', ['method', 'requiredperms']],

		['description', ['method', 'description', '_content']],

		['response', ['method', 'response', '_content'], 'optional' => TRUE],

		['arguments', ['arguments', 'argument'], 'class' => 'Intahwebz\FlickrGuzzle\DTO\MethodArgument', 'multiple' => TRUE ],
		['errors', ['errors', 'error'], 'class' => 'Intahwebz\FlickrGuzzle\DTO\MethodError', 'multiple' => TRUE ],
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


//	static function createFromJson($data){
//		$object = self::createFromJsonAuto($data);
//
//		$remap = array(
//			'description',
//			'response',
//		);
//
//		$object->remap($remap, '_content');
//
//		return $object;
//	}
}

?>