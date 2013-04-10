<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class User {

	use DataMapper;

	static protected $dataMap = array(
		['nsid', 'nsid', 'optional' => TRUE],			//Returned by PhotoInfo?
		['nsid', 'user_nsid', 'optional' => TRUE],		//returned by OauthAccessToken
		['username', 'username'],
		['fullname','fullname'],
	);

	var $nsid;
	var $username;
	var $fullname;
}