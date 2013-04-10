<?php


namespace Intahwebz\FlickrAPI\DTO;

use Intahwebz\FlickrAPI\DataMapper;

class PublicEditability {


	use DataMapper;

	static protected $dataMap = array(
		['canComment','cancomment'],// => int 1
		['canAddMeta','canaddmeta'],// => int 0
	);

	var $canComment;
	var $canAddMeta;

}