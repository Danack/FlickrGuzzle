<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class Visibility {

	use DataMapper;

	var $isPublic;
	var $isFriend;
	var $isFamily;

	static protected $dataMap = array(
		['isPublic',	'ispublic'],
		['isFriend',	'isfriend'],
		['isFamily',	'isfamily'],
	);
}