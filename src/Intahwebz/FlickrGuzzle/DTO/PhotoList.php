<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

use Intahwebz\Utils\JSONFactory;



class PhotoList {

	use DataMapper;
	use JSONFactory;

	static protected $dataMap = array(
		['page', 'page'],
		['pages', 'pages'],
		['perPage', 'perpage'],
		['total', 'total'],
		['photos', 'photo', 'class' => 'Intahwebz\\FlickrGuzzle\\DTO\\Photo', 'multiple' => TRUE ],
	);

	var $page;
	var $pages;
	var $perPage;
	var $total;

	var $photos = array();
}
