<?php

namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class Place {

	var $placeID;
	var $woeID;
	var $latitude;
	var $longitude;
	var $placeURL;
	var $placeType;
	var $name;

	use DataMapper;

	static protected $dataMap = array(
		['placeID', 'place_id'],
		['woeID', 'woeid'],
		['latitude', 'latitude'],
		['longitude', 'longitude'],
		['placeURL', 'place_url'],
		['placeType', 'place_type'],
		['name', '_content'],
	);
}