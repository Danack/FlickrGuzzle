<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class CameraBrand {

	use DataMapper;

	var $cameraBrandID;
	var	$name;

	static protected $dataMap = array(
		['cameraBrandID', 'id'],
		['name', 'name'],
	);
}