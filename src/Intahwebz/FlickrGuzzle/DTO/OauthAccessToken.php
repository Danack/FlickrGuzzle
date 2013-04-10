<?php


namespace Intahwebz\FlickrAPI\DTO;

use Intahwebz\FlickrAPI\DataMapper;

class OauthAccessToken {

	use DataMapper;

	public static $dataMap = array(
		['oauthToken', 'oauth_token'],
		['oauthTokenSecret', 'oauth_token_secret'],
		['user', null, 'class' => 'Intahwebz\\FlickrAPI\\DTO\\User' ]
	);

	var $oauthToken;
	var $oauthTokenSecret;

	/** @var User */
	var $user;


//	var $fullname;
//	var $userNSID;
//	var $username;
}