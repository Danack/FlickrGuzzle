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

		['visibility', 'visibility', 'class' => 'Intahwebz\FlickrGuzzle\DTO\Visibility' ],
		['photo', null, 'class' => 'Intahwebz\FlickrGuzzle\DTO\Photo' ],
		['dates', 'dates', 'class' => 'Intahwebz\FlickrGuzzle\DTO\Dates', ],//  ],
		['urls', ['urls', 'url'], 'class' => 'Intahwebz\FlickrGuzzle\DTO\URL', 'multiple' => TRUE ],
		['tags', ['tags', 'tag'], 'class' => 'Intahwebz\FlickrGuzzle\DTO\Tag', 'multiple' => TRUE ],
		['usage', 'usage', 'class' => 'Intahwebz\FlickrGuzzle\DTO\Usage' ],
		//['geoPerms', 'geoperms', 'class' => 'Intahwebz\FlickrGuzzle\DTO\GeoPerms' ],
		['editability', 'editability', 'class' => 'Intahwebz\FlickrGuzzle\DTO\Editability' ],

		['publicEditability', 'publiceditability', 'class' => 'Intahwebz\FlickrGuzzle\DTO\PublicEditability' ],
		['notes', ['notes', 'note'], 'class' => 'Intahwebz\FlickrGuzzle\DTO\Note', 'multiple' => true ]
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
	var $notes = array();

	/**
	 * @var Tag[]
	 */
	var $tags = array();

	/**
	 * @var URL[]
	 */
	var $urls = array();

}