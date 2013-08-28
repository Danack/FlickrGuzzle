<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class LookupUser {

	use DataMapper;

	static protected $dataMap = array(
		['userID', 'id'],
		['username', ['username', '_content']],
	);

	var $userID; //shurely NSID?
	var $username;
}

