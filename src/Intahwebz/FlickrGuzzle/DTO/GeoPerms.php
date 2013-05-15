<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class GeoPerms {

	use DataMapper;

	static protected $dataMap = array(
		['isPublic',	'ispublic'],
		['isContact',	'iscontact'],
		['isFriend',	'isfriend'],
		['isFamily', 	'isfamily'],
	);

	var $isPublic;
	var $isContact;
	var $isFriend;
	var $isFamily;

}