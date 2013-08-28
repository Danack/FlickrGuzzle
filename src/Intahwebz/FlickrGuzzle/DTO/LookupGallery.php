<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class LookupGallery {

	use DataMapper;

	static protected $dataMap = array(
		['galleryID',	'id'],
		['url',		'url'],
		['owner',	'owner'],
		['primaryPhotoID',	'primary_photo_id'],
		['dateCreate',	'date_create'],
		['dateUpdate',	'date_update'],
		['countPhotos',	'count_photos'],
		['countVideos',	'count_videos'],
		['countViews',	'count_views'],
		['countComments',	'count_comments'],
		['server', 'server', 'optional' => true],
		['farm', 'farm', 'optional' => true],
		['secret', 'secret', 'optional' => true ],
		['title', ['title', '_content']],
		['description', ['description', '_content' ]],

		['primaryPhotoServer', 'primary_photo_server'],
		['primaryPhotoFarm', 'primary_photo_farm'],
		['primaryPhotoSecret', 'primary_photo_secret'],
	);

	var $galleryID;
	var $url;
	var $owner;
	var $primaryPhotoID;
	var $dateCreate;
	var $dateUpdate;

	var $countPhotos;
	var $countVideos;
	var $countViews;
	var $countComments;

	var $primaryPhotoServer;
	var $primaryPhotoFarm;
	var $primaryPhotoSecret;

	var $server;
	var $farm;
	var $secret;
	var $title;
	var $description;
}
