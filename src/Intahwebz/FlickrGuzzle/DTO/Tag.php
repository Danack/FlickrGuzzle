<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class Tag {

	use DataMapper;

	static protected $dataMap = array(
		['tagID', 		'id', 'optional' => true],
		['authorID',	'author', 'optional' => true],

		['raw',		'raw', 'optional' => true],
		['raw',		['raw', '_content'], 'optional' => true], //returned by getUserRawTags

		['text',	'_content', 'optional' => true],
		['text',	'clean', 'optional' => true], //returned by getUserRawTags

		['machineTag',	'machine_tag', 'optional' => true],

		['count', 'count', 'optional' => true],
	);

	var $tagID;
	var $authorID;
	var $raw;
	var $text;
	var $machineTag;

	var $count = null;
}