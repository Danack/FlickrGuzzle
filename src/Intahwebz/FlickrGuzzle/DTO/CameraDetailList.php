<?php


namespace Intahwebz\FlickrAPI\DTO;

use Intahwebz\FlickrAPI\DataMapper;

class CameraDetailList {

	use DataMapper;

	static protected $dataMap = array(
		['cameraDetails', 'camera', 'class' => 'Intahwebz\\FlickrAPI\\DTO\\CameraDetail', 'multiple' => true ],
	);

	var $cameraDetails = array();
}