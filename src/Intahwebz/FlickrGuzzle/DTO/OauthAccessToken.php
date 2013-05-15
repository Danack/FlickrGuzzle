<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class OauthAccessToken {

	use DataMapper;

	public static $dataMap = array(
		['oauthToken', 'oauth_token'],
		['oauthTokenSecret', 'oauth_token_secret'],
		['user', NULL, 'class' => 'Intahwebz\FlickrGuzzle\DTO\User' ]
	);

	var $oauthToken;
	var $oauthTokenSecret;

	/** @var User */
	var $user;


//	var $fullname;
//	var $userNSID;
//	var $username;
}