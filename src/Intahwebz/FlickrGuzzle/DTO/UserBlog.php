<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class UserBlog {

	use DataMapper;

	static protected $dataMap = array(
		['id', 'id'],
		['name', 'name'],
		['needsPassword', 'needspassword'],
		['url',	'url'],
	);

	var $id;
	var $name;
	var $needsPassword;
	var $url;
}