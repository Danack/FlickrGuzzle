<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class LookupGroup {

	use DataMapper;

	static protected $dataMap = array(
		['groupID', 'id'],
		['groupName', ['groupname', '_content']],
	);

	var $groupID; //shurely NSID?
	var $groupName;
}



?>