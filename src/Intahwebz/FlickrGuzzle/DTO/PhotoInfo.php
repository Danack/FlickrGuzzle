<?php


namespace Intahwebz\FlickrAPI\DTO;

use Intahwebz\FlickrAPI\DataMapper;

class PhotoInfo {


	use DataMapper{
		createFromData as createFromDataAuto;
	}

	static protected $dataMap = array(
		['views', 'views'],
		['media', 'media'],
		['isFavorite', 'isfavorite'],
		['license', 'license'],
		['rotation', 'rotation'],

		['visibility', 'visibility', 'class' => 'Intahwebz\\FlickrAPI\\DTO\\Visibility' ],
		['photo', null, 'class' => 'Intahwebz\\FlickrAPI\\DTO\\Photo' ],
		['dates', 'dates', 'class' => 'Intahwebz\\FlickrAPI\\DTO\\Dates', ],//  ],
		['urls', ['urls', 'url'], 'class' => 'Intahwebz\\FlickrAPI\\DTO\\URL', 'multiple' => true ],
		['tags', ['tags', 'tag'], 'class' => 'Intahwebz\\FlickrAPI\\DTO\\Tag', 'multiple' => true ],
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