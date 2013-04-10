<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class CameraDetailList {

	use DataMapper;

	static protected $dataMap = array(
		['cameraDetails', 'camera', 'class' => 'Intahwebz\\FlickrAPI\\DTO\\CameraDetail', 'multiple' => TRUE ],
	);

	var $cameraDetails = array();
}