<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class PhotoInfo {


	use DataMapper;

	static protected $dataMap = array(
		['views', 'views'],
		['media', 'media'],
		['isFavorite', 'isfavorite'],
		['license', 'license'],
		['rotation', 'rotation'],

		['visibility', 'visibility', 'class' => 'Intahwebz\\FlickrAPI\\DTO\\Visibility' ],
		['photo', NULL, 'class' => 'Intahwebz\\FlickrAPI\\DTO\\Photo' ],
		['dates', 'dates', 'class' => 'Intahwebz\\FlickrAPI\\DTO\\Dates', ],//  ],
		['urls', ['urls', 'url'], 'class' => 'Intahwebz\\FlickrAPI\\DTO\\URL', 'multiple' => TRUE ],
		['tags', ['tags', 'tag'], 'class' => 'Intahwebz\\FlickrAPI\\DTO\\Tag', 'multiple' => TRUE ],
		['usage', 'usage', 'class' => 'Intahwebz\\FlickrAPI\\DTO\\Usage' ],
		//['geoPerms', 'geoperms', 'class' => 'Intahwebz\\FlickrAPI\\DTO\\GeoPerms' ],
		['editability', 'editability', 'class' => 'Intahwebz\\FlickrAPI\\DTO\\Editability' ],

		['publicEditability', 'publiceditability', 'class' => 'Intahwebz\\FlickrAPI\\DTO\\PublicEditability' ],
	);

	var $views;
	var $media;
	var $isFavorite;
	var $license;
	var $rotation;

	/**
	 * @var Photo
	 */
	var $photo;

	/**
	 * @var Owner
	 */
	var $owner;


	/**
	 * @var Visibility
	 */
	var $visibility;

	/**
	 * @var Dates
	 */
	var $dates;


	/**
	 * @var GeoPerms
	 */
	//var $geoPerms;

	/**
	 * @var Permissions
	 */
	var $permissions;

	/**
	 * @var Editability
	 */
	var $editability;

	/**
	 * @var Integer
	 */
	var $comments;

	/**
	 * @var Note[]
	 */
	var $flickrNotes = array();

	/**
	 * @var Tag[]
	 */
	var $tags = array();

	/**
	 * @var URL[]
	 */
	var $urls = array();

}