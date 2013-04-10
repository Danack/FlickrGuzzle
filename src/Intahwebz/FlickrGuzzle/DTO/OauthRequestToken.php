<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class OauthRequestToken {

	use DataMapper;

	public static $dataMap = array(
		['oauthCallbackConfirmed', 'oauth_callback_confirmed'],
		['oauthToken', 'oauth_token'],
		['oauthTokenSecret', 'oauth_token_secret'],
	);

	var $oauthCallbackConfirmed;
	var $oauthToken;
	var $oauthTokenSecret;


}