<?php

namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class UserList{

	use DataMapper;

	static protected $dataMap = array(
		['users', 'contact', 'class' => 'Intahwebz\\FlickrGuzzle\\DTO\\Owner', 'multiple' => TRUE ],
		['page', 'page'],
		['pages', 'pages'],
		['perPage', 'perpage'],
		['total', 'total'],
	);

	public $users;
	public $total;
	public $pages;
	public $perPage;
	public $page;
}


?>