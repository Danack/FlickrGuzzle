<?php


namespace Intahwebz\FlickrAPI\DTO;

use Intahwebz\FlickrAPI\DataMapper;

class User {

	use DataMapper;

	static protected $dataMap = array(
		['nsid', 'nsid', 'optional' => true],			//Returned by PhotoInfo?
		['nsid', 'user_nsid', 'optional' => true],		//returned by OauthAccessToken
		['username', 'username'],
		['fullname','fullname'],
	);

	var $nsid;
	var $username;
	var $fullname;
}