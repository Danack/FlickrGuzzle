<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class Tag {

	use DataMapper;

	static protected $dataMap = array(
		['tagID', 		'id', 'optional' => true],
		['authorID',	'author', 'optional' => true],
		['raw',			'raw', 'optional' => true],
		['text',		'_content'],
		['machineTag',	'machine_tag', 'optional' => true]
	);

	var $tagID;
	var $authorID;
	var $raw;
	var $text;
	var $machineTag;
}