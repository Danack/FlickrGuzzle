<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;


class MethodList {

	use DataMapper{
		createFromData as createFromDataAuto;
	}

	static protected $dataMap = array(
		['methods', 'method', 'multiple' => TRUE ],
	);

	var $methods = array();


	static function createFromData($data){
		$object = self::createFromDataAuto($data);

		foreach ($object->methods as &$method) {
			$method = $method['_content'];	//zomg
		}

		return $object;
	}

}

//<methods>
//		  <method>flickr.blogs.getList</method>
//		  <method>flickr.blogs.postPhoto</method>
//		  <method>flickr.contacts.getList</method>
//		  <method>flickr.contacts.getPublicList</method>
//		</methods>


?>