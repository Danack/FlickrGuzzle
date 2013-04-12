<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class URLInfo {

	use DataMapper;

	static protected $dataMap = array(
		['nsid', ['group', 'nsid'], 'optional' => 'true'],
		['url', ['group','url'], 'optional' => 'true'],
		['nsid', ['user', 'nsid'], 'optional' => 'true'],
		['url', ['user','url'], 'optional' => 'true'],
	);

	var $nsid;
	var $url;

}



?>