<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;


class LicenseList {

	use DataMapper;

	static protected $dataMap = array(
		['licenses', ['licenses', 'license'], 'class' => 'Intahwebz\FlickrGuzzle\DTO\License', 'multiple' =>  true],
	);

	var $licenses = array();
}

