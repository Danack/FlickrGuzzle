<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class AccountStat {

	var $totalViews;
	var $photosViews;
	var $photostreamViews;
	var $setsViews;
	var $collectionsViews;

	use DataMapper;

	static protected $dataMap = array(
		['totalViews', ['total', 'views']],
		['photosViews', ['photos', 'views']],
		['photostreamViews', ['photostream', 'views']],
		['setsViews', ['sets', 'views']],
		['collectionsViews', 	['collections', 'views']],
	);
}