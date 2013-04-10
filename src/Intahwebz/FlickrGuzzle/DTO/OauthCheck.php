<?php


namespace Intahwebz\FlickrAPI\DTO;

use Intahwebz\FlickrAPI\DataMapper;


/**
 * Class OauthCheck
 *
 * This should only be used as the result of an call to check that an OauthAccessToken is valid. It should not be written to.
 *
 * @package Intahwebz\FlickrAPI\DTO
 */
class OauthCheck {

	use DataMapper{
		createFromData as createFromDataAuto;
	}

	public static $dataMap = array(
//		['oauthToken', 'oauth_token'],
//		['oauthTokenSecret', 'oauth_token_secret'],
		['permissions', 'perms'],
		['user', 'user', 'class' => 'Intahwebz\\FlickrAPI\\DTO\\User' ]
	);

	var $permissions;
	var $user;

	/**
	 * @param $data
	 * @return static
	 */
	static function createFromData($data){
		$object = self::createFromDataAuto($data);

		$remap = array(
			'permissions',
		);

		$object->remap($remap, '_content');

		return $object;
	}

}

?>