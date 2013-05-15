<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class BlogServiceList {

	use DataMapper;

	static protected $dataMap = array(
		['blogServiceList',	'service', 'multiple' => true, 'class' => 'Intahwebz\FlickrGuzzle\DTO\BlogService'],
	);

	var $blogServiceList = array();
}


