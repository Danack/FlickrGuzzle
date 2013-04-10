<?php


namespace Intahwebz\FlickrAPI\DTO;

use Intahwebz\FlickrAPI\DataMapper;

class CameraBrand {

	use DataMapper;

	var $cameraBrandID;
	var	$name;

	static protected $dataMap = array(
		['cameraBrandID', 'id'],
		['name', 'name'],
	);

}