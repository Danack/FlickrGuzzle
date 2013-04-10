<?php


namespace Intahwebz\FlickrAPI\DTO;

use Intahwebz\FlickrAPI\DataMapper;

class GeoPerms {

	use DataMapper;

	static protected $dataMap = array(

		['isPublic', 'ispublic'],
		['isContact', 'iscontact'],
		['isFriend', 'isfriend'],
		['isFamily', 	'isfamily'],
	);

	var $isPublic;
	var $isContact;
	var $isFriend;
	var $isFamily;

}