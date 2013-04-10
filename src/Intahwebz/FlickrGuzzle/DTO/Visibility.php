<?php


namespace Intahwebz\FlickrAPI\DTO;

use Intahwebz\FlickrAPI\DataMapper;

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