<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class NoteID {

	use DataMapper;

	static protected $dataMap = array(
		['noteID', 'id'],
	);

	var $noteID;
}