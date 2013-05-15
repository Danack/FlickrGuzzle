<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class UserBlogList {

	use DataMapper;

	static protected $dataMap = array(
		['blogList',	'blog', 'multiple' => true, 'class' => 'Intahwebz\FlickrGuzzle\DTO\UserBlog'],
	);

	var $blogList = array();
}