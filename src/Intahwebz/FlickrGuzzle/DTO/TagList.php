<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class TagList {

	use DataMapper;

	static protected $dataMap = array(
		['tags', ['tags', 'tag'], 'class' => 'Intahwebz\\FlickrGuzzle\\DTO\\Tag',  'multiple' => true],
	);

	var $tags = array();
}