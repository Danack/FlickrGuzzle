<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class BlogService {

	use DataMapper;

	static protected $dataMap = array(
		['id', 'id'],
		['name', '_content'],
	);

	var $id;
	var $name;
}