<?php


namespace PHPSTORM_META {                                                 // we want to avoid the pollution

	//require_once "vendor/autoload.php";

	/** @noinspection PhpUnusedLocalVariableInspection */
	/** @noinspection PhpIllegalArrayKeyTypeInspection */
	$STATIC_METHOD_TYPES = [
		\Intahwebz\FlickrGuzzle\FlickrGuzzleClient::factoryWithCommand('') => [
			'GetOauthRequestToken' instanceof \Intahwebz\FlickrGuzzle\DTO\OauthRequestToken,
			'GetOauthAccessToken' instanceof \Intahwebz\FlickrGuzzle\DTO\OauthAccessToken,
			'UploadPhoto' instanceof \Intahwebz\FlickrGuzzle\DTO\FileUploadResponse,
			'flickr.activity.userComments' instanceof \Intahwebz\FlickrGuzzle\DTO\ActivityInfo,
			'flickr.activity.userPhotos' instanceof \Intahwebz\FlickrGuzzle\DTO\ActivityInfo,
			'flickr.auth.oauth.checkToken' instanceof \Intahwebz\FlickrGuzzle\DTO\OauthCheck,
			'flickr.cameras.getBrandModels' instanceof \Intahwebz\FlickrGuzzle\DTO\CameraDetailList,
			'flickr.cameras.getBrands' instanceof \Intahwebz\FlickrGuzzle\DTO\CameraBrandList,
			'flickr.commons.getInstitutions' instanceof \Intahwebz\FlickrGuzzle\DTO\InstitutionList,
			'flickr.people.getPhotos' instanceof \Intahwebz\FlickrGuzzle\DTO\PhotoList,
			'flickr.people.getPublicPhotos' instanceof \Intahwebz\FlickrGuzzle\DTO\PhotoList,
			'flickr.photos.getInfo' instanceof \Intahwebz\FlickrGuzzle\DTO\PhotoInfo,
			'flickr.photos.getUntagged' instanceof \Intahwebz\FlickrGuzzle\DTO\PhotoList,
			'flickr.photos.licenses.getInfo' instanceof \Intahwebz\FlickrGuzzle\DTO\LicenseList,
			'flickr.photos.notes.add' instanceof \Intahwebz\FlickrGuzzle\DTO\NoteID,
			'flickr.photos.transform.rotate' instanceof \Intahwebz\FlickrGuzzle\DTO\PhotoInfoTransform,
			'flickr.reflection.getMethodInfo' instanceof \Intahwebz\FlickrGuzzle\DTO\MethodInfo,
			'flickr.reflection.getMethods' instanceof \Intahwebz\FlickrGuzzle\DTO\MethodList,
			'flickr.tags.getHotList' instanceof \Intahwebz\FlickrGuzzle\DTO\TagList,
			'flickr.tags.getListPhoto' instanceof \Intahwebz\FlickrGuzzle\DTO\TagList,
			'flickr.tags.getListUser' instanceof \Intahwebz\FlickrGuzzle\DTO\TagList,
			'flickr.tags.getListUserPopular' instanceof \Intahwebz\FlickrGuzzle\DTO\TagList,
			'flickr.tags.getListUserRaw' instanceof \Intahwebz\FlickrGuzzle\DTO\TagList,
			'flickr.tags.getMostFrequentlyUsed' instanceof \Intahwebz\FlickrGuzzle\DTO\TagList,
			'flickr.tags.getRelated' instanceof \Intahwebz\FlickrGuzzle\DTO\TagList,
			'flickr.urls.getGroup' instanceof \Intahwebz\FlickrGuzzle\DTO\URLInfo,
			'flickr.urls.getUserPhotos' instanceof \Intahwebz\FlickrGuzzle\DTO\URLInfo,
			'flickr.urls.getUserProfile' instanceof \Intahwebz\FlickrGuzzle\DTO\URLInfo,
			'flickr.urls.lookupGallery' instanceof \Intahwebz\FlickrGuzzle\DTO\LookupGallery,
			'flickr.urls.lookupGroup' instanceof \Intahwebz\FlickrGuzzle\DTO\LookupGroup,
			'flickr.urls.lookupUser' instanceof \Intahwebz\FlickrGuzzle\DTO\LookupUser,
		],
	];
}