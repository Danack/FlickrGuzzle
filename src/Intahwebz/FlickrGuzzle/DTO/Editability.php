<?php


namespace Intahwebz\FlickrAPI\DTO;

use Intahwebz\FlickrAPI\DataMapper;

class Editability {

	use DataMapper;

	static protected $dataMap = array(
		['canComment', 'cancomment'],
		['canAddMeta', 'canaddmeta'],
	);

	var $canComment;
	var $canAddMeta;

}