<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class ActivityInfo {

	use DataMapper;

	static protected $dataMap = array(
		['page', 'page'],
		['pages', 'pages'],
		['perPage', 'perpage'],
		['total', 'total'],
		['activityItemList', 'item', 'class' => 'Intahwebz\FlickrGuzzle\DTO\ActivityItem', 'multiple' => true],
	);

	var $activityItemList = array();

	var $page;
	var $pages;
	var $perPage;
	var $total;
}
