<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class Note {

	use DataMapper;

	static protected $dataMap = array(
		['noteID', 'id'],
		['authorID', 'author'],
		['authorName', 'authorname'],
		['x', 'x'],
		['y', 'y'],
		['w', 'w'],
		['h', 'h'],
		['text', '_content'],
	);

	var $noteID;
	var $authorID;
	var $authorName;
	var $x;
	var $y;
	var $w;
	var $h;

	var $text;
}