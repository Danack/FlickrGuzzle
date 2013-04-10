<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class Usage {

	use DataMapper;

	static protected $dataMap = array(
		['canDownload', 'candownload'],
		['canBlog', 'canblog'],
		['canPrint', 'canprint'],
		['canShare', 'canshare'],
	);

	var $canDownload;
	var $canBlog;
	var $canPrint;
	var $canShare;
}