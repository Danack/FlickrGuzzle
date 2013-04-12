<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class TagList {

	use DataMapper;

	static protected $dataMap = array(
		[	'tags',
			['tags', 'tag'],
			'class' => 'Intahwebz\\FlickrGuzzle\\DTO\\Tag',
			'multiple' => true,
			'optional' => true
		],
		//tags.getHotList doesn't contain the array in a 'tags' element
		[	'tags',
			'tag',
			'class' => 'Intahwebz\\FlickrGuzzle\\DTO\\Tag',
			'multiple' => true,
			'optional' => true
		],
	);

	var $tags = array();
}