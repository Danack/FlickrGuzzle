<?php


namespace Intahwebz\FlickrAPI\DTO;

use Intahwebz\FlickrAPI\DataMapper;

class Dates {

	var $posted;//="1100897479"
	var $taken;//="2004-11-19 12:51:19"
	var $takenGranularity;//="0"
	var $lastUpdate;//="1093022469" />

	use DataMapper;

	static protected $dataMap = array(
		['posted', 'posted'],
		['taken', 'taken'],
		['takenGranularity', 'takengranularity'],
		['lastUpdate', 'lastupdate']
	);
}