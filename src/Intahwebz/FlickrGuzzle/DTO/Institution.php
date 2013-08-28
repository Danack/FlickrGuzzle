<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class Institution {

	use DataMapper{
		createFromJson as createFromJsonAuto;
	}

	static protected $dataMap = array(
		['nsid',	'nsid'],
		['dateLaunch',	'date_launch'],
		['name',	'name'],
		['urls', 	['urls', 'url'], 'class' => 'Intahwebz\FlickrGuzzle\DTO\URL', 'multiple' => true],
	);

	var $nsid;
	var $dateLaunch;
	var $name;

	var $urls = array();

	static function createFromJson($data){
		$object = self::createFromJsonAuto($data);
		$object->name = $object->name['_content'];
		return $object;
	}

}
