<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;


class ActivityEvent {

	use DataMapper;

	static protected $dataMap = array(
		['type', 'type'],
		['user', 'user'],
		['username', 'username'],

		['iconServer','iconserver'],
		['iconFarm', 'iconfarm'],
		['commentID', 'commentid', 'optional' => true],//Only there for type comment presumably
		['noteID', 'noteid', 'optional' => true],//Only there for type note presumably.
		['dateAdded', 'dateadded'],
		['text', '_content'],
	);

	var $type;
	var $user; //Shurely NSID?
	var $username;

	var $dateAdded;
	var $text;

	var $iconServer;
	var $iconFarm;

	//Only one of these two will be set (presumably?)
	var $commentID;
	var $noteID;
}

