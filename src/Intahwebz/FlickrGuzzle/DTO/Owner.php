<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class Owner {


	use DataMapper;

	static protected $dataMap = array(
		['nsID',		'nsid'],
		['userName', 	'username'],
		['realName', 	'realname', 'optional' => true],
		['location',	'location', 'optional' => true],
		['iconServer',	'iconserver'],
		['iconFarm',	'iconfarm'],
		['pathAlias', 	'path_alias', 'optional' => true],
	);

	var $nsID;//="12037949754@N01"
	var $userName;//="Bees"
	var $realName;//="Cal Henderson"
	var $location;//="Bedford, UK" />

	var $iconServer;
	var $iconFarm;
	var $pathAlias;
}