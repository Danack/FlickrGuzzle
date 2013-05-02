<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class FileUploadResponse {

	use DataMapper;
//{
//		createFromJson as createFromJsonAuto;
//	}

	static protected $dataMap = array(
		['photoID', ['photoid', '_content']],
	);

	var $photoID;

//	static function createFromJson($data){
//		$object = self::createFromJsonAuto($data);
//
//		$remap = array(
//			'photoID',
//		);
//
//		$object->remap($remap, '_content');
//
//		return $object;
//	}

}



?>