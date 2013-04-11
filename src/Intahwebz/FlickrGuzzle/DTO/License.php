<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class License {

	use DataMapper;

	static protected $dataMap = array(
		['id', 'id'],
		['name', 'name'],
		['url', 'url'],
	);

	var $id;
	var $name;
	var $url;
}


?>