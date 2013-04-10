<?php


namespace Intahwebz\FlickrAPI\DTO;

use Intahwebz\FlickrAPI\DataMapper;

class Owner {


	use DataMapper;

	static protected $dataMap = array(
		'nsID'			=>	'nsid',// => string '46085186@N02' (length=12)
		'userName' 		=>	'username',// => string 'Danack57' (length=8)
		'realName' 		=>	'realname',// => string 'Dan Ackroyd' (length=11)
		'location'		=>	'location',// => string 'Sydney, Australia' (length=17)
		'iconServer'	=>	'iconserver',// => string '4062' (length=4)
		'iconFarm'		=>	'iconfarm',// => int 5
		'pathAlias' 	=>	'path_alias',// => string 'danack' (length=6)
	);

	var $nsID;//="12037949754@N01"
	var $userName;//="Bees"
	var $realName;//="Cal Henderson"
	var $location;//="Bedford, UK" />

	var $iconServer;
	var $iconFarm;
	var $pathAlias;

	//'nsid' => string '46085186@N02' (length=12)
	//'username' => string 'Danack57' (length=8)
	//'realname' => string 'Dan Ackroyd' (length=11)
	//'location' => string 'Sydney, Australia' (length=17)
	//'iconserver' => string '4062' (length=4)
	//'iconfarm' => int 5
	//'path_alias' => string 'danack' (length=6)

}