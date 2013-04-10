<?php


namespace Intahwebz\FlickrAPI;

use Guzzle\Plugin\Oauth\OauthPlugin;
use Guzzle\Http\Message\EntityEnclosingRequest;


class FlickrOauthPlugin extends OauthPlugin {
	/**
	 * Decide whether the post fields should be added to the Oauth BaseString.
	 * Flickr incorrectly add the post fields when the content type is 'multipart/form-data'. They should only be added when the content type is 'application/x-www-form-urlencoded'
	 *
	 * @param $request
	 * @return bool Whether the post fields should be signed or not
	 */
	public function		shouldPostFieldsBeSigned($request) {
		if (!$this->config->get('disable_post_params') ){
			if ($request instanceof EntityEnclosingRequest ) {
				return true;
			}
		}
		return false;
	}
}



?>