<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class Editability {

	use DataMapper;

	static protected $dataMap = array(
		['canComment', 'cancomment'],
		['canAddMeta', 'canaddmeta'],
	);

	var $canComment;
	var $canAddMeta;

}