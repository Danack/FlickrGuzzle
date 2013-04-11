<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class LookupGallery {

	use DataMapper;

	static protected $dataMap = array(
		['$galleryID', '$galleryID'],
		['$url', '$url'],
		['$owner', '$owner'],
		['primary_photo_id', 'primary_photo_id'],
		['date_create', 'date_create'],
		['date_update', 'date_update'],
		['count_photos', 'count_photos'],
		['count_videos', 'count_videos'],
		['server', 'server'],
		['farm', 'farm'],
		['secret', 'secret'],
		['title', 'title'],
		['description', 'description'],
	);

	var $galleryID;
	var $url;
	var $owner;
	var $primary_photo_id;
	var $date_create;
	var $date_update;
	var $count_photos;
	var $count_videos;
	var $server;
	var $farm;
	var $secret;
	var $title;
	var $description;

}



?>