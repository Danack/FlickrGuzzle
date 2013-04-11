<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class InstitutionList {

	use DataMapper;

	static protected $dataMap = array(
		['institutions', 'institution', 'class' => 'Intahwebz\\FlickrGuzzle\\DTO\\Institution', 'multiple' => 'true'],
	);

	var $institutions = array();
}



?>