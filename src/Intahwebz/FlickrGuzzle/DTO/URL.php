<?php


namespace Intahwebz\FlickrAPI\DTO;

use Intahwebz\FlickrAPI\DataMapper;

class URL {

	use DataMapper;

	static protected $dataMap = array(
		['type', 'type'],
		['url', '_content'],
	);

	var $type;			//="photopage">
	var $url = null;	//http://www.flickr.com/photos/bees/2733/</url>
}