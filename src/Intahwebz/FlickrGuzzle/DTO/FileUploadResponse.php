<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class FileUploadResponse {

	use DataMapper;

	static protected $dataMap = array(
		['photoID', ['photoid', '_content']],
	);

	var $photoID;
}

