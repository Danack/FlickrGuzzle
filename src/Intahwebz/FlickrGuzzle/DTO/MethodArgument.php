<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class MethodArgument {

	use DataMapper;

	static protected $dataMap = array(
		['name', 'name'],
		['optional', 'optional'],
	);

	var $name;
	var $optional;
}
