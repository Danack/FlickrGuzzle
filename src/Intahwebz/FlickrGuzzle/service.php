<?php

return array (

	//		var $rest_endpoint = 'http://api.flickr.com/services/rest/';
	//		var $upload_endpoint = 'http://api.flickr.com/services/upload/';
	//		var $replace_endpoint = 'http://api.flickr.com/services/replace/';

	"name" => "FlickAPI",
    "baseUrl" => "http://api.flickr.com/services/",
    "description" => "Flickr API using Guzzle as a backend",
    "operations" => array(

		'defaultGetOperation' => array(
			"httpMethod" => "GET",
			"uri" => "rest/",
			"parameters" => array(
				'api_key' => array(
					"location" => "query",
					"description" => "",
					//"required" => false,
					'default' => FLICKR_KEY,
				),
				'format' => array(
					"location" => "query",
					"description" => "",
					//"required" => false,
					'default' =>  'json',
				),
				'nojsoncallback' => array(
					"location" => "query",
					"description" => "",
					//"required" => false,
					'default' => 1
				),
				/*'user_id' => array(
					"location" => "query",
					"description" => "",
					//"required" => false,
					'default' => '46085186@N02'
				),*/
			)
		),


		"GetOauthRequestToken" => array(
			"httpMethod" => "GET",
			'uri' => 'http://www.flickr.com/services/oauth/request_token',
			"summary" => "Starts the Oauth process.",
			"responseClass" => "Intahwebz\\FlickrAPI\\DTO\\OauthRequestToken",

			"parameters" => array(
				'oauth_callback' => array(
					"location" => "query",
					"description" => "",
					//'default' => 'http://basereality.test/flickrAuth',
					'required' => true,
				),
			),
		),




		"GetOauthAccessToken" => array(
			"httpMethod" => "GET",
			'uri' => 'http://www.flickr.com/services/oauth/access_token',
			"summary" => "Exchanges Oauth request token for access token.",
			"responseClass" => "Intahwebz\\FlickrAPI\\DTO\\OauthAccessToken",

			"parameters" => array(

//There is a bug in the Flickr api. Although this is meant to be passed as a parameter, doing
//			a so results in a 'bad signature'.
//				'oauth_token' => array(
//					"location" => "query",
//					"description" => "The Oauth token that will be exchanged for an access token.",
//					'required' => true,
//				),
				'oauth_verifier' => array(
					"location" => "query",
					"description" => "The oauth_verifier that shows that the user was redirected back to your site.",
					'required' => true,
				),
			),
		),

		"CheckToken" => array(
			'extends' => 'defaultGetOperation',
			"summary" => "Checks whether the Oauth token+secret are valid",
			"responseClass" => "Intahwebz\\FlickrAPI\\DTO\\OauthCheck",
			"parameters" => array(
				'oauth_token' => array(
					"location" => "query",
					"description" => "The Oauth token that will be checked for validity.",
					'required' => false,
				),
				'method'    => array(
					"location" => "query",
					"description" => "Which flickr call is being made.",
					'default' => 'flickr.auth.oauth.checkToken',
				),
			)
		),


		"GetPhotoList" => array(
			'extends' => 'defaultGetOperation',
            "summary" => "Get a set of thumbnails",
			"responseClass" => "Intahwebz\\FlickrAPI\\DTO\\PhotoList",
            "parameters" => array(
				"per_page" => array(
					"location" => "query",
                    "description" => "How many photos to fetch per page",
                    "required" => true
				),
				'page' => array(
					"location" => "query",
					"description" => "Page offset.",
					"required" => false
				),
				'method'    => array(
					"location" => "query",
					"description" => "Which flickr call is being made.",
					'default' => 'flickr.people.getPhotos',
				),
				'user_id' => array(
					"location" => "query",
					"description" => "userID (NSID) of whose photos to get.",
					"required" => true
				),

				//safe_search
				//min_upload_date
				//max_upload_date
				//min_taken_date
				//max_taken_date
				//content_type
				//privacy_filter
				//extras
			)
		),




		"AddTag" => array(
			'extends' => 'defaultGetOperation',
			"summary" => "Get a set of thumbnails",
			"responseClass" => "Intahwebz\\FlickrAPI\\DTO\\PhotoList",
			"parameters" => array(
				"photo_id" => array(
					"location" => "query",
					"description" => "Which photo to add the tag to.",
					"required" => true
				),
				'tags' => array(
					"location" => "query",
					"description" => "Tags to add",
					"required" => true
				),
				'method'    => array(
					"location" => "query",
					"description" => "Which flickr call is being made.",
					'default' => 'flickr.photos.addTags',
				),
			)
		),

		"RemoveTag" => array(
			'extends' => 'defaultGetOperation',
			"summary" => "Get a set of thumbnails",
			"responseClass" => "Intahwebz\\FlickrAPI\\DTO\\PhotoList",
			"parameters" => array(

				'tag_id' => array(
					"location" => "query",
					"description" => "Which tags to remove",
					"required" => true
				),
				'method'    => array(
					"location" => "query",
					"description" => "Which flickr call is being made.",
					'default' => 'flickr.photos.removeTag',
				),
			)
		),

		"GetUntaggedPhoto" => array(
			'extends' => 'defaultGetOperation',
			"summary" => "Get a set of thumbnails",
			"responseClass" => "Intahwebz\\FlickrAPI\\DTO\\PhotoList",
			"parameters" => array(
				'per_page' => array(
					"location" => "query",
					"description" => "",
					"required" => true
				),
				'page' => array(
					"location" => "query",
					"description" => "",
					"required" => true
				),
				'method'    => array(
					"location" => "query",
					"description" => "Which flickr call is being made.",
					'default' => 'flickr.photos.getUntagged',
				),
			)
		),



		"GetPublicPhotoList" => array(
			'extends' => 'defaultGetOperation',
			"summary" => "Get a set of thumbnails",
			"responseClass" => "Intahwebz\\FlickrAPI\\DTO\\PhotoList",
			"parameters" => array(
				"per_page" => array(
					"location" => "query",
					"description" => "How many photos to fetch per page",
					"required" => true
				),
				'page' => array(
					"location" => "query",
					"description" => "Page offset.",
					"required" => false
				),
				'method'    => array(
					"location" => "query",
					"description" => "Which flickr call is being made.",
					'default' => 'flickr.people.getPublicPhotos',
				),
			)
		),

		"GetPhotoInfo" => array(
			'extends' => 'defaultGetOperation',
			"summary" => "Get a set of thumbnails",
			"responseClass" => "Intahwebz\\FlickrAPI\\DTO\\PhotoInfo",
			"parameters" => array(
				"photo_id" => array(
					"location" => "query",
					"description" => "The id of the photo to get information for.",
					"required" => true
				),
				'method'    => array(
					"location" => "query",
					"description" => "Which flickr call is being made.",
					'default' => 'flickr.photos.getInfo',
				),
			)
		),


		"GetBrands" => array(
			'extends' => 'defaultGetOperation',
			"summary" => "Returns all the brands of cameras that Flickr knows about.",
			"responseClass" => "Intahwebz\\FlickrAPI\\DTO\\CameraBrandList",
			"parameters" => array(
				'method'    => array(
					"location" => "query",
					"description" => "Which flickr call is being made.",
					'default' => 'flickr.cameras.getBrands',
				),
			)
		),

		"GetBrandModels" => array(
			'extends' => 'defaultGetOperation',
			"summary" => "Retrieve all the models for a given camera brand.",
			"responseClass" => "Intahwebz\\FlickrAPI\\DTO\\CameraDetailList",
			"parameters" => array(
				'brand'    => array(
					"location" => "query",
					"description" => "Which brand to get the models for.",
				),
				'method'    => array(
					"location" => "query",
					"description" => "Which flickr call is being made.",
					'default' => 'flickr.cameras.getBrandModels',
				),
			)
		),



		"UploadPhoto" => array(
			"httpMethod" => "POST",
			'uri' => 'http://api.flickr.com/services/upload/',
			"summary" => "Uploads a photo.",
			"responseClass" => "Intahwebz\\FlickrAPI\\DTO\\FileUploadResponse",


			//Query parameters are just ignored...have to use postField

//			postField - bad sig
//			query - throw no error, isn't used
//			header
//			body - throws no error, aren't used.

			"parameters" => array(
				'format' => array(
					"location" => "postField",
					"description" => "",
					'default' =>  'json',
				),
				'photo' => array(
					"location" => "postFile",
					"description" => "The file to upload",
					'required' => true,
				),
				'title' => array(
					"location" => "postField",
					"description" => "The title of the photo.",
				),
				'description' => array(
					"location" => "postField",
					"description" => "The description of the photo",
				),
				'tags' => array(
					"location" => "postField",
					"description" => "A space-separated list of tags to apply to the photo.",
				),

				'async' => array(
					"location" => "postField",
					"description" => "Whether to process the file asynchronously.",
				),

				'is_public' => array(
					"location" => "postField",
					"description" => "",
					'default' => 0,
				),
				'is_friend' => array(
					"location" => "postField",
					"description" => "",
					'default' => 0,
				),
				'is_family' => array(
					"location" => "postField",
					"description" => "",
					'default' => 0,
				),


				//	safety_level  //Set to 1 for Safe, 2 for Moderate, or 3 for Restricted.
				//	content_type //Set to 1 for Photo, 2 for Screenshot, or 3 for Other.
				//	hidden  //  Set to 1 to keep the photo in global search results, 2 to hide from public searches.
			),
		),
	),

    "models" => array(
	),
);



?>