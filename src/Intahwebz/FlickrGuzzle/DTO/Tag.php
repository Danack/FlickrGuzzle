<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class Tag {

	use DataMapper;

	static protected $dataMap = array(
		['tagID', 		'id'],
		['authorID',	'author'],
		['raw',			'raw'],
		['text',		'_content'],
		['machineTag',	'machine_tag']
	);

	var $tagID;
	var $authorID;
	var $raw;
	var $text;
	var $machineTag;
}