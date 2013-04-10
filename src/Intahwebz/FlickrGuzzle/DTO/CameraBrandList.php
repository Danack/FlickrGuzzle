<?php


namespace Intahwebz\FlickrAPI\DTO;

use Intahwebz\FlickrAPI\DataMapper;


class CameraBrandList {

	use DataMapper;

	static protected $dataMap = array(
		['cameraBrands', 'brand', 'class' => 'Intahwebz\\FlickrAPI\\DTO\\CameraBrand', 'multiple' => true ],
	);

	var $cameraBrands = array();
}