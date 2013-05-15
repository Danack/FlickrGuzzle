<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class PlaceList {

	use DataMapper;

	static protected $dataMap = array(
		['places', 'place', 'class' => 'Intahwebz\FlickrGuzzle\DTO\Place', 'multiple' => 'true'],
	);

	var $places = array();
}



?>