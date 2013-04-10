<?php

namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\Utils as Utils;
use Intahwebz\FlickrGuzzle\DataMapper;

//Photo sizes
//s	small square 75x75
//q	large square 150x150
//t	thumbnail, 100 on longest side
//m	small, 240 on longest side
//n	small, 320 on longest side
//	-	medium, 500 on longest side
//z	medium 640, 640 on longest side
//c	medium 800, 800 on longest side†
//b	large, 1024 on longest side*
//	o	original image, either a jpg, gif or png, depending on source format


class Photo {

	use DataMapper;

	var $photoID;   	//Unique Id
	var $owner;			//the owner of the photo
	var $secret;		//Used to give access to the photo without Oauth
	var $serverID;		//The serverID that the photo is hosted on.
	var $farmID;
	var $title;

	static protected $dataMap = array(
		['photoID', 'id'],
		['owner', 'owner'],
		['secret', 'secret'],
		['serverID', 'server'],
		['farmID', 'farm'],
		['title', 'title'],
	);

	/* public static function fromCommand(OperationCommand $command){
//		echo "wut";
//		var_dump($command->getResponse());


		//$stream = $command->getRequest()->getResponse()->getBody()->getStream();
		$data = $command->getRequest()->getResponse()->getBody(true);

		$dataJson = json_decode($data, true);
		var_dump($dataJson);
		exit(0);

		return new self();
		// Return an instantiated DeleteRequest object
		//return new DeleteRequest($key, $table);
	}*/

	function getImageURL($size = 'q'){
		return "http://farm".$this->farmID.".staticflickr.com/".$this->serverID."/".$this->photoID."_".$this->secret."_".$size.".jpg";
	}

	function	getPhotoURL(){
		return "http://www.flickr.com/photos/".$this->owner."/".$this->photoID;
	}
}


?>