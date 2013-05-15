<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class ActivityItem {

	use DataMapper;

	static protected $dataMap = array(
		['type', 'type'],
		['id', 'id'],
		['owner', 'owner'],
		['ownerName', 'ownername'],
		['iconServer', 'iconserver'],
		['iconFarm', 'iconfarm'],
		['primary', 'primary', 'optional' => true],
		['secret', 'secret'],
		['server', 'server'],
		['commentsOld', 'commentsold', 'optional' => true],
		['commentsNew', 'commentsnew', 'optional' => true],
		['views', 'views'],
		['photos', 'photos', 'optional' => true],
		['more', 'more', 'optional' => true],
		['activityEventList',
			['activity', 'event'],
			'class' => 'Intahwebz\FlickrGuzzle\DTO\ActivityEvent',
			'multiple' => true
		],
		['title', 'title'],
		['media', 'media'],
		['notes', 'notes'],
		['faves', 'faves'],
	);

	var $type;
	var $id;
	var $owner;
	var $ownerName;
	var $iconServer;
	var $iconFarm;
	var $primary;
	var $secret;
	var $server;
	var $commentsOld;
	var $commentsNew;
	var $views;
	var $photos;
	var $more;

	var $title; //=> '_content';
	var $media;
	var $notes;	//These are going to be note objects
	var $faves;

	var $activityEventList = array();
}



?>