<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;


/**
 * Class PhotoInfoTransform Only used to store the result of the transform function. No actual useful information in it.
 * @package Intahwebz\FlickrGuzzle\DTO
 */

class PhotoInfoTransform {

	use DataMapper;

	static protected $dataMap = array(
		['photoID', '_content'],
		['secret', 'secret'],
		['originalSecret', 'originalsecret'],
	);

	var $photoID;
	var $secret;
	var $originalSecret;
}



?>