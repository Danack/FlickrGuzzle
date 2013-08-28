<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;


/**
 * Class OauthCheck
 *
 * This should only be used as the result of an call to check that an OauthAccessToken is valid. It should not be written to.
 *
 * @package Intahwebz\FlickrGuzzle\DTO
 */
class OauthCheck {

	use DataMapper;

	public static $dataMap = array(
		//TODO - Shouldn't this be multiple e.g. read + write? or does flickr just return one
		//permission that implies others e.g. write => read + write
		['permissions', ['perms', '_content']],
		['user', 'user', 'class' => 'Intahwebz\FlickrGuzzle\DTO\User' ]
	);

	var $permissions;
	var $user;
}
