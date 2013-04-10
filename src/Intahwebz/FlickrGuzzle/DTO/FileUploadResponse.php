<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class FileUploadResponse {

	use DataMapper{
		createFromData as createFromDataAuto;
	}

	static protected $dataMap = array(
		['photoID', 'photoid'],
	);

	var $photoID;

	static function createFromData($data){
		$object = self::createFromDataAuto($data);

		$remap = array(
			'photoID',
		);

		$object->remap($remap, '_content');

		return $object;
	}

}



?>