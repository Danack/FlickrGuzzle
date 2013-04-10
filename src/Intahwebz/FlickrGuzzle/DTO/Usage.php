<?php


namespace Intahwebz\FlickrAPI\DTO;

use Intahwebz\FlickrAPI\DataMapper;

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