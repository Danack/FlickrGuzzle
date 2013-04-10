<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;


class CameraBrandList {

	use DataMapper;

	static protected $dataMap = array(
		['cameraBrands', 'brand', 'class' => 'Intahwebz\\FlickrAPI\\DTO\\CameraBrand', 'multiple' => TRUE ],
	);

	var $cameraBrands = array();
}