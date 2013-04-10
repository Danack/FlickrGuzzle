<?php


namespace Intahwebz\FlickrAPI\DTO;

use Intahwebz\FlickrAPI\DataMapper;

class PhotoList {

	use DataMapper;

	static protected $dataMap = array(
		['page', 'page'],
		['pages', 'pages'],
		['perPage', 'perpage'],
		['total', 'total'],
		['photos', 'photo', 'class' => 'Intahwebz\\FlickrAPI\\DTO\\Photo', 'multiple' => true ],
	);

	var $page;
	var $pages;
	var $perPage;
	var $total;

	var $photos = array();
}
