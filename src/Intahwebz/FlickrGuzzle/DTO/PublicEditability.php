<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class PublicEditability {


	use DataMapper;

	static protected $dataMap = array(
		['canComment','cancomment'],// => int 1
		['canAddMeta','canaddmeta'],// => int 0
	);

	var $canComment;
	var $canAddMeta;

}