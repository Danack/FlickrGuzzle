<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class URL {

	use DataMapper;

	static protected $dataMap = array(
		['type', 'type'],
		['url', '_content'],
	);

	var $type;			//="photopage">
	var $url = NULL;	//http://www.flickr.com/photos/bees/2733/</url>
}