<?php

return array (

	//		var $rest_endpoint = 'http://api.flickr.com/services/rest/';
	//		var $upload_endpoint = 'http://api.flickr.com/services/upload/';
	//		var $replace_endpoint = 'http://api.flickr.com/services/replace/';

	"name" => "FlickAPI",
    "baseUrl" => "http://api.flickr.com/services/rest/",
    "description" => "Flickr API using Guzzle as a backend",
    "operations" => array(

		//The first three operations are made to a different URL than all the other requests
		"GetOauthRequestToken" => array(
			"httpMethod" => "GET",
			'uri' => 'http://www.flickr.com/services/oauth/request_token',
			"summary" => "Starts the Oauth process.",
			"responseClass" => "Intahwebz\\FlickrGuzzle\\DTO\\OauthRequestToken",

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
			"responseClass" => "Intahwebz\\FlickrGuzzle\\DTO\\OauthAccessToken",

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


		"UploadPhoto" => array(
			"httpMethod" => "POST",
			'uri' => 'http://api.flickr.com/services/upload/',
			"summary" => "Uploads a photo.",
			"responseClass" => "Intahwebz\\FlickrGuzzle\\DTO\\FileUploadResponse",

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


		//Every other method is made to just the base URL

		'defaultGetOperation' => array(
			"httpMethod" => "GET",
			"parameters" => array(
				'format' => array(
					"location" => "query",
					"description" => "",
					'default' =>  'json',
				),
				'api_key' => array(
					"location" => "query",
					"description" => "",
					//"required" => false,
					'default' => FLICKR_KEY,
				),
				'nojsoncallback' => array(
					"location" => "query",
					"description" => "",
					//"required" => false,
					'default' => 1
				),
			)
		),


		/*

		"CheckToken" => array(
			'extends' => 'defaultGetOperation',
			"summary" => "Checks whether the Oauth token+secret are valid",
			"responseClass" => "Intahwebz\\FlickrGuzzle\\DTO\\OauthCheck",
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
		), */

		/*

		"GetPhotoList" => array(
			'extends' => 'defaultGetOperation',
            "summary" => "Get a set of thumbnails",
			"responseClass" => "Intahwebz\\FlickrGuzzle\\DTO\\PhotoList",
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
			"responseClass" => "Intahwebz\\FlickrGuzzle\\DTO\\PhotoList",
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
			"responseClass" => "Intahwebz\\FlickrGuzzle\\DTO\\PhotoList",
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
			"responseClass" => "Intahwebz\\FlickrGuzzle\\DTO\\PhotoList",
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
			"responseClass" => "Intahwebz\\FlickrGuzzle\\DTO\\PhotoList",
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
			"responseClass" => "Intahwebz\\FlickrGuzzle\\DTO\\PhotoInfo",
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
			"responseClass" => "Intahwebz\\FlickrGuzzle\\DTO\\CameraBrandList",
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
			"responseClass" => "Intahwebz\\FlickrGuzzle\\DTO\\CameraDetailList",
			"parameters" => array(
				'brand'    => array(
					"location" => "query",
					"description" => "Which brand to get the models for.",
					"required" => true,
				),
				'method'    => array(
					"location" => "query",
					"description" => "Which flickr call is being made.",
					'default' => 'flickr.cameras.getBrandModels',
				),
			)
		),

		"getMethodInfo" => array(
			'extends' => 'defaultGetOperation',
			"summary" => "Retrieve all the models for a given camera brand.",
			"responseClass" => "Intahwebz\\FlickrGuzzle\\DTO\\MethodInfo",
			"parameters" => array(
				'method_name'    => array(
					"location" => "query",
					"description" => "Which method_name to get info of.",
					"required" => true,
				),
				'method'    => array(
					"location" => "query",
					"description" => "Which flickr call is being made.",
					'default' => 'flickr.reflection.getMethodInfo',
				),
			)
		),


		"GetMethodsList" => array(
			'extends' => 'defaultGetOperation',
			"summary" => "Retrieve all the models for a given camera brand.",
			"responseClass" => "Intahwebz\\FlickrGuzzle\\DTO\\MethodList",
			"parameters" => array(
				'method'    => array(
					"location" => "query",
					"description" => "Which flickr call is being made.",
					'default' => 'flickr.reflection.getMethods',
				),
			)
		), */

// Start of autogenerated service
// 1
		"flickr.activity.userComments" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns a list of recent activity on photos commented on by the calling user. <b>Do not poll this method more than once an hour</b>.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<items>
	<item type="photoset" id="395" owner="12037949754@N01" 
		primary="6521" secret="5a3cc65d72" server="2" 
		comments="1" views="33" photos="7" more="0">
		<title>A set of photos</title>
		<activity>
			<event type="comment"
			user="12037949754@N01" username="Bees"
			dateadded="1144086424">yay</event>
		</activity>
	</item>

	<item type="photo" id="10289" owner="12037949754@N01"
		secret="34da0d3891" server="2" comments="1"
		notes="0" views="47" faves="0" more="0">
		<title>A photo</title>
		<activity>
			<event type="comment"
			user="12037949754@N01" username="Bees"
			dateadded="1133806604">test</event>
			<event type="note"
			user="12037949754@N01" username="Bees"
			dateadded="1118785229">nice</event>
		</activity>
	</item>
</items>
*/
			'parameters' => array(
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.activity.userComments',
				),
			),
		),

// 2
		"flickr.activity.userPhotos" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns a list of recent activity on photos belonging to the calling user. <b>Do not poll this method more than once an hour</b>.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<items>
	<item type="photoset" id="395" owner="12037949754@N01" 
		primary="6521" secret="5a3cc65d72" server="2" 
		commentsold="1" commentsnew="1"
		views="33" photos="7" more="0">
		<title>A set of photos</title>
		<activity>
			<event type="comment"
			user="12037949754@N01" username="Bees"
			dateadded="1144086424">yay</event>
		</activity>
	</item>

	<item type="photo" id="10289" owner="12037949754@N01"
		secret="34da0d3891" server="2"
		commentsold="1" commentsnew="1"
		notesold="0" notesnew="1"
		views="47" faves="0" more="0">
		<title>A photo</title>
		<activity>
			<event type="comment"
			user="12037949754@N01" username="Bees"
			dateadded="1133806604">test</event>
			<event type="note"
			user="12037949754@N01" username="Bees"
			dateadded="1118785229">nice</event>
		</activity>
	</item>
</items>
*/
			'parameters' => array(
				'timeframe'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.activity.userPhotos',
				),
			),
		),

// 3
		"flickr.auth.checkToken" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns the credentials attached to an authentication token. This call <b>must</b> be signed, and is <b><a href="/services/api/auth.oauth.html">deprecated in favour of OAuth</a></b>.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<auth>
	<token>976598454353455</token>
	<perms>read</perms>
	<user nsid="12037949754@N01" username="Bees" fullname="Cal H" />
</auth>
*/
			'parameters' => array(
				'auth_token'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.auth.checkToken',
				),
			),
		),

// 4
		"flickr.auth.getFrob" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns a frob to be used during authentication. <b>This method call must be signed</b>, and is <b><a href="/services/api/auth.oauth.html">deprecated in favour of OAuth</a></b>.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<frob>746563215463214621</frob>
*/
			'parameters' => array(
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.auth.getFrob',
				),
			),
		),

// 5
		"flickr.auth.getFullToken" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get the full authentication token for a mini-token. <b>This method call must be signed</b>, and is <b><a href="/services/api/auth.oauth.html">deprecated in favour of OAuth</a></b>.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<auth>
	<token>976598454353455</token>
	<perms>write</perms>
	<user nsid="12037949754@N01" username="Bees" fullname="Cal H" />
</auth>
*/
			'parameters' => array(
				'mini_token'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.auth.getFullToken',
				),
			),
		),

// 6
		"flickr.auth.getToken" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns the auth token for the given frob, if one has been attached. <b>This method call must be signed</b>, and is <b><a href="/services/api/auth.oauth.html">deprecated in favour of OAuth</a></b>.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<auth>
	<token>976598454353455</token>
	<perms>write</perms>
	<user nsid="12037949754@N01" username="Bees" fullname="Cal H" />
</auth>
*/
			'parameters' => array(
				'frob'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.auth.getToken',
				),
			),
		),

// 7
		"flickr.auth.oauth.checkToken" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns the credentials attached to an OAuth authentication token.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<oauth>
    <token>72157627611980735-09e87c3024f733da</token>
    <perms>write</perms>
    <user nsid="1121451801@N07" username="jamalf" fullname="Jamal F"/>
</oauth>
*/
			'parameters' => array(
				'oauth_token'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.auth.oauth.checkToken',
				),
			),
		),

// 8
		"flickr.auth.oauth.getAccessToken" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Exchange an auth token from the old Authentication API, to an OAuth access token. Calling this method will delete the auth token used to make the request.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<auth> 
	<access_token oauth_token="72157607082540144-8d5d7ea7696629bf" oauth_token_secret="f38bf58b2d95bc8b" /> 
</auth> 
*/
			'parameters' => array(
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.auth.oauth.getAccessToken',
				),
			),
		),

// 9
		"flickr.blogs.getList" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get a list of configured blogs for the calling user.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<blogs>
	<blog id="73" name="Bloxus test" needspassword="0"
		url="http://remote.bloxus.com/" /> 
	<blog id="74" name="Manila Test" needspassword="1"
		url="http://flickrtest1.userland.com/" /> 
</blogs>
*/
			'parameters' => array(
				'service'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.blogs.getList',
				),
			),
		),

// 10
		"flickr.blogs.getServices" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Return a list of Flickr supported blogging services',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<services>
<service id="beta.blogger.com">Blogger</service>
<service id="Typepad">Typepad</service>
<service id="MovableType">Movable Type</service>
<service id="LiveJournal">LiveJournal</service>
<service id="MetaWeblogAPI">Wordpress</service>
<service id="MetaWeblogAPI">MetaWeblogAPI</service>
<service id="Manila">Manila</service>
<service id="AtomAPI">AtomAPI</service>
<service id="BloggerAPI">BloggerAPI</service>
<service id="Vox">Vox</service>
<service id="Twitter">Twitter</service>
</services>
*/
			'parameters' => array(
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.blogs.getServices',
				),
			),
		),

// 11
		"flickr.blogs.postPhoto" => array(
			'extends' => 'defaultGetOperation',
			'summary' => '',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'blog_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'title'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'description'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'blog_password'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'service'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.blogs.postPhoto',
				),
			),
		),

// 12
		"flickr.cameras.getBrandModels" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Retrieve all the models for a given camera brand.',
			"responseClass" => "Intahwebz\\FlickrGuzzle\\DTO\\CameraDetailList",
			'parameters' => array(
				'brand'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.cameras.getBrandModels',
				),
			),
		),

// 13
		"flickr.cameras.getBrands" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns all the brands of cameras that Flickr knows about.',
			"responseClass" => "Intahwebz\\FlickrGuzzle\\DTO\\CameraBrandList",
			'parameters' => array(
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.cameras.getBrands',
				),
			),
		),

// 14
		"flickr.collections.getInfo" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns information for a single collection.  Currently can only be called by the collection owner, this may change.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<collection id="12-72157594586579649" child_count="6" datecreate="1173812218" iconlarge="http://farm1.static.flickr.com/187/cols/73743fac2cf79_l.jpg" iconsmall="http://farm1.static.flickr.com/187/cols/72157594586579649_43fac2cf79_s.jpg" server="187" secret="36">
<title>All My Photos</title>
<description>Photos!</description>
<iconphotos>
<photo id="14" owner="12@N01" secret="b57ba5c" server="51" farm="1" title="in full cap and gown" ispublic="1" isfriend="0" isfamily="0"/>
<photo id="15" owner="12@N01" secret="ba1c2a8" server="58" farm="1" title="Just beyond the door" ispublic="0" isfriend="1" isfamily="0"/>
<photo id="17" owner="12@N01" secret="0001969" server="73" farm="1" title="IMG_3787.JPG" ispublic="1" isfriend="0" isfamily="0"/>
....
</iconphotos>
</collection>
*/
			'parameters' => array(
				'collection_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.collections.getInfo',
				),
			),
		),

// 15
		"flickr.collections.getTree" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns a tree (or sub tree) of collections belonging to a given user.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<collections>
<collection id="12-72157594586579649" title="All My Photos" description="a collection" iconlarge="http://farm1.static.flickr.com/187/cols/37_43fac2cf79_l.jpg" 
iconsmall="http://farm1.static.flickr.com/187/cols/56_43fac2cf79_s.jpg">
<set id="92157594171298291" title="kitesurfing" description="a set"/>
<set id="72157594247596158" title="faves" description="some favorites."/>
</collection>
</collections>
*/
			'parameters' => array(
				'collection_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'user_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.collections.getTree',
				),
			),
		),

// 16
		"flickr.commons.getInstitutions" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Retrieves a list of the current Commons institutions.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<rsp stat="ok">
 <institutions>
  <institution nsid="123456@N01" date_launch="1232000000">
   <name>Institution</name>
    <urls>
     <url type="site">http://example.com/</url>
     <url type="license">http://example.com/commons/license</url>
     <url type="flickr">http://flickr.com/photos/institution</url>
    </urls>
   </institution>
  </institutions>
</rsp>
*/
			'parameters' => array(
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.commons.getInstitutions',
				),
			),
		),

// 17
		"flickr.contacts.getList" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get a list of contacts for the calling user.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<contacts page="1" pages="1" perpage="1000" total="3">
	<contact nsid="12037949629@N01" username="Eric" iconserver="1"
		realname="Eric Costello"
		friend="1" family="0" ignored="1" /> 
	<contact nsid="12037949631@N01" username="neb" iconserver="1"
		realname="Ben Cerveny"
		friend="0" family="0" ignored="0" /> 
	<contact nsid="41578656547@N01" username="cal_abc" iconserver="1"
		realname="Cal Henderson"
		friend="1" family="1" ignored="0" />
</contacts>
*/
			'parameters' => array(
				'filter'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'sort'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.contacts.getList',
				),
			),
		),

// 18
		"flickr.contacts.getListRecentlyUploaded" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Return a list of contacts for a user who have recently uploaded photos along with the total count of photos uploaded.<br /><br />

This method is still considered experimental. We don\'t plan for it to change or to go away but so long as this notice is present you should write your code accordingly.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'date_lastupload'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'filter'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.contacts.getListRecentlyUploaded',
				),
			),
		),

// 19
		"flickr.contacts.getPublicList" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get the contact list for a user.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<contacts page="1" pages="1" perpage="1000" total="3">
	<contact nsid="12037949629@N01" username="Eric" iconserver="1" ignored="1" /> 
	<contact nsid="12037949631@N01" username="neb" iconserver="1" ignored="0" /> 
	<contact nsid="41578656547@N01" username="cal_abc" iconserver="1" ignored="0" />
</contacts>
*/
			'parameters' => array(
				'user_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'show_more'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.contacts.getPublicList',
				),
			),
		),

// 20
		"flickr.contacts.getTaggingSuggestions" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get suggestions for tagging people in photos based on the calling user\'s contacts.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<rsp stat="ok">
<contacts page="1" pages="1" perpage="1000" total="1">
	<contact nsid="30135021@N05" username="Hugo Haas" iconserver="1" iconfarm="1" realname="" friend="0" family="0" path_alias="" />
</contacts>
</rsp>
*/
			'parameters' => array(
				'include_self'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'include_address_book'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.contacts.getTaggingSuggestions',
				),
			),
		),

// 21
		"flickr.favorites.add" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Adds a photo to a user\'s favorites list.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.favorites.add',
				),
			),
		),

// 22
		"flickr.favorites.getContext" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns next and previous favorites for a photo in a user\'s favorites.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<rsp stat='ok'>
<count>3</count>
<prevphoto id="2980" secret="973da1e709"
	title="boo!" url="/photos/bees/2980/" /> 
<nextphoto id="2985" secret="059b664012"
	title="Amsterdam Amstel" url="/photos/bees/2985/" />
</rsp>
*/
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'user_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'num_prev'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'num_next'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'extras'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.favorites.getContext',
				),
			),
		),

// 23
		"flickr.favorites.getList" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns a list of the user\'s favorite photos. Only photos which the calling user has permission to see are returned.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'user_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'jump_to'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'min_fave_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'max_fave_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'extras'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.favorites.getList',
				),
			),
		),

// 24
		"flickr.favorites.getPublicList" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns a list of favorite public photos for the given user.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'user_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'jump_to'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'min_fave_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'max_fave_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'extras'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.favorites.getPublicList',
				),
			),
		),

// 25
		"flickr.favorites.remove" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Removes a photo from a user\'s favorites list.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'user_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.favorites.remove',
				),
			),
		),

// 26
		"flickr.galleries.addPhoto" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Add a photo to a gallery.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'gallery_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'comment'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.galleries.addPhoto',
				),
			),
		),

// 27
		"flickr.galleries.create" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Create a new gallery for the calling user.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
  <gallery id="50736-72157623680420409" url="http://www.flickr.com/photos/kellan/galleries/72157623680420409" /> 

*/
			'parameters' => array(
				'title'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'description'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'primary_photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.galleries.create',
				),
			),
		),

// 28
		"flickr.galleries.editMeta" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Modify the meta-data for a gallery.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'gallery_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'title'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'description'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.galleries.editMeta',
				),
			),
		),

// 29
		"flickr.galleries.editPhoto" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Edit the comment for a gallery photo.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'gallery_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'comment'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.galleries.editPhoto',
				),
			),
		),

// 30
		"flickr.galleries.editPhotos" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Modify the photos in a gallery. Use this method to add, remove and re-order photos.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'gallery_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'primary_photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'photo_ids'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.galleries.editPhotos',
				),
			),
		),

// 31
		"flickr.galleries.getInfo" => array(
			'extends' => 'defaultGetOperation',
			'summary' => '',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<gallery id="6065-72157617483228192" url="http://www.flickr.com/photos/straup/galleries/72157617483228192" 
owner="35034348999@N01" 
         primary_photo_id="292882708" date_create="1241028772" date_update="1270111667" count_photos="17"
 count_videos="0" primary_photo_server="112" primary_photo_farm="1" primary_photo_secret="7f29861bc4">
	<title>Cat Pictures I've Sent To Kevin Collins</title>
	<description />
</gallery>
*/
			'parameters' => array(
				'gallery_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.galleries.getInfo',
				),
			),
		),

// 32
		"flickr.galleries.getList" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Return the list of galleries created by a user.  Sorted from newest to oldest.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<galleries total="9" page="1" pages="1" per_page="100" user_id="34427469121@N01">
   <gallery id="5704-72157622637971865" 
             url="http://www.flickr.com/photos/george/galleries/72157622637971865" 
             owner="34427469121@N01" date_create="1257711422" date_update="1260360756"
             primary_photo_id="107391222"  primary_photo_server="39" 
             primary_photo_farm="1" primary_photo_secret="ffa"
             count_photos="16" count_videos="2" >
       <title>I like me some black &amp; white</title>
       <description>black and whites</description>
   </gallery>
   <gallery id="5704-72157622566655097" 
            url="http://www.flickr.com/photos/george/galleries/72157622566655097" 
            owner="34427469121@N01" date_create="1256852229" date_update="1260462343" 
            primary_photo_id="497374910" primary_photo_server="231" 
            primary_photo_farm="1" primary_photo_secret="9ae0f"
            count_photos="18" count_videos="0" >
       <title>People Sleeping in Libraries</title>
       <description />
   </gallery>
</galleries>
*/
			'parameters' => array(
				'user_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.galleries.getList',
				),
			),
		),

// 33
		"flickr.galleries.getListForPhoto" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Return the list of galleries to which a photo has been added.  Galleries are returned sorted by date which the photo was added to the gallery.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<galleries total="7" page="1" pages="1" per_page="100">
    <gallery id="9634-72157621980433950" 
             url="http://www.flickr.com/photos/revdancatt/galleries/72157621980433950" 
             owner="35468159852@N01" date_create="1249748647" date_update="1260486168" 
	     primary_photo_id="2080242123" primary_photo_server="2209" 
	     primary_photo_farm="3" primary_photo_secret="55c9"
             count_photos="18" count_videos="0">
        <title>Vivitar Ultra Wide &amp; Slim Selection</title>
        <description>The cheap and cheerful camera that isn't quite as cheap as it used to be.</description>
    </gallery>
   <gallery id="22342631-72157622254010831" 
             url="http://www.flickr.com/photos/22365685@N03/galleries/72157622254010831" 
             owner="22365685@N03" date_create="1253035020" date_update="1260431618" 
             primary_photo_id="3182914049" primary_photo_server="3319" 
             primary_photo_farm="4" primary_photo_secret="b94fb"
             count_photos="13" count_videos="0">
        <title>Awesome Pics</title>
        <description />
    </gallery>
</galleries>
*/
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.galleries.getListForPhoto',
				),
			),
		),

// 34
		"flickr.galleries.getPhotos" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Return the list of photos for a gallery',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<photos page="1" pages="1" perpage="500" total="2">
	<photo id="2822546461" owner="78398753@N00" secret="2dbcdb589f" server="1" farm="1" title="FOO" 
     ispublic="1" isfriend="0" isfamily="0" is_primary="1" has_comment="1">
		<comment>best cat picture ever!</comment>
	</photo>
	<photo id="2822544806" owner="78398753@N00" secret="bd93cbe917" server="1" farm="1" title="OOK" 
     ispublic="1" isfriend="0" isfamily="0" is_primary="0" has_comment="0" />
</photos>
*/
			'parameters' => array(
				'gallery_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'extras'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.galleries.getPhotos',
				),
			),
		),

// 35
		"flickr.groups.browse" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Browse the group category tree, finding groups and sub-categories.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<category name="Alt" path="/Alt" pathids="/63">
	<subcat id="80" name="18+" count="0" /> 
	<subcat id="82" name="Absurd" count="4" /> 
	<group nsid="34955637532@N01" name="Cal's Public Test Group"
		members="13" online="1" chatnsid="34955637533@N01" inchat="0" /> 
	<group nsid="34158032587@N01" name="Eric's Alt Group Test"
		members="3" online="0" chatnsid="34158032588@N01" inchat="0" /> 
</category>

*/
			'parameters' => array(
				'cat_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.groups.browse',
				),
			),
		),

// 36
		"flickr.groups.discuss.replies.add" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Post a new reply to a group discussion topic.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'topic_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'message'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.groups.discuss.replies.add',
				),
			),
		),

// 37
		"flickr.groups.discuss.replies.delete" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Delete a reply from a group topic.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'topic_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'reply_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.groups.discuss.replies.delete',
				),
			),
		),

// 38
		"flickr.groups.discuss.replies.edit" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Edit a topic reply.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'topic_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'reply_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'message'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.groups.discuss.replies.edit',
				),
			),
		),

// 39
		"flickr.groups.discuss.replies.getInfo" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get information on a group topic reply.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<?xml version="1.0" encoding="utf-8" ?>
<rsp stat="ok">
  <reply id="72157607082559968" author="30134652@N05" authorname="JAMAL'S ACCOUNT" is_pro="0" role="admin" iconserver="0" iconfarm="0" can_edit="1" can_delete="1" datecreate="1337975921" lastedit="0">
    <message>...well, too bad.</message>
  </reply>
</rsp>
*/
			'parameters' => array(
				'topic_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'reply_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.groups.discuss.replies.getInfo',
				),
			),
		),

// 40
		"flickr.groups.discuss.replies.getList" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get a list of replies from a group discussion topic.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<rsp stat="ok">
  <replies>
    <topic topic_id="72157625038324579" subject="A long time ago in a galaxy far, far away..." group_id="46744914@N00" iconserver="1" iconfarm="1" name="Tell a story in 5 frames (Visual story telling)" author="53930889@N04" authorname="Smallportfolio_jm08" role="member" author_iconserver="5169" author_iconfarm="6" can_edit="0" can_delete="0" can_reply="0" is_sticky="0" is_locked="" datecreate="1287070965" datelastpost="1336905518" total="8" page="1" per_page="3" pages="2">
      <message>&lt;div&gt;&lt;span class=&quot;photo_container pc_m bbml_img&quot;&gt;&lt;a href=&quot;/photos/53930889@N04/5080874079/&quot; title=&quot;Star Wars 1 by Smallportfolio_jm08&quot;&gt;&lt;img class=&quot;notsowide&quot; src=&quot;http://farm5.staticflickr.com/4035/5080874079_684cf874e0_m.jpg&quot; width=&quot;240&quot; height=&quot;180&quot; alt=&quot;Star Wars 1 by Smallportfolio_jm08&quot;  class=&quot;pc_img&quot; border=&quot;0&quot; /&gt;&lt;/a&gt;&lt;/span&gt;&lt;/div&gt;

&lt;div&gt;&lt;span class=&quot;photo_container pc_m bbml_img&quot;&gt;&lt;a href=&quot;/photos/53930889@N04/5081467846/&quot; title=&quot;Star Wars 2 by Smallportfolio_jm08&quot;&gt;&lt;img class=&quot;notsowide&quot; src=&quot;http://farm5.staticflickr.com/4071/5081467846_2eec86176d_m.jpg&quot; width=&quot;240&quot; height=&quot;180&quot; alt=&quot;Star Wars 2 by Smallportfolio_jm08&quot;  class=&quot;pc_img&quot; border=&quot;0&quot; /&gt;&lt;/a&gt;&lt;/span&gt;&lt;/div&gt;

&lt;div&gt;&lt;span class=&quot;photo_container pc_m bbml_img&quot;&gt;&lt;a href=&quot;/photos/53930889@N04/5081467886/&quot; title=&quot;Star Wars 3 by Smallportfolio_jm08&quot;&gt;&lt;img class=&quot;notsowide&quot; src=&quot;http://farm5.staticflickr.com/4021/5081467886_d8cca6c8e8_m.jpg&quot; width=&quot;240&quot; height=&quot;180&quot; alt=&quot;Star Wars 3 by Smallportfolio_jm08&quot;  class=&quot;pc_img&quot; border=&quot;0&quot; /&gt;&lt;/a&gt;&lt;/span&gt;&lt;/div&gt;

&lt;div&gt;&lt;span class=&quot;photo_container pc_m bbml_img&quot;&gt;&lt;a href=&quot;/photos/53930889@N04/5081467910/&quot; title=&quot;Star Wars 4 by Smallportfolio_jm08&quot;&gt;&lt;img class=&quot;notsowide&quot; src=&quot;http://farm5.staticflickr.com/4084/5081467910_274bb11fdc_m.jpg&quot; width=&quot;240&quot; height=&quot;180&quot; alt=&quot;Star Wars 4 by Smallportfolio_jm08&quot;  class=&quot;pc_img&quot; border=&quot;0&quot; /&gt;&lt;/a&gt;&lt;/span&gt;&lt;/div&gt;

&lt;div&gt;&lt;span class=&quot;photo_container pc_m bbml_img&quot;&gt;&lt;a href=&quot;/photos/53930889@N04/5081467948/&quot; title=&quot;Star Wars 5 by Smallportfolio_jm08&quot;&gt;&lt;img class=&quot;notsowide&quot; src=&quot;http://farm5.staticflickr.com/4154/5081467948_1a5f200bc0_m.jpg&quot; width=&quot;240&quot; height=&quot;180&quot; alt=&quot;Star Wars 5 by Smallportfolio_jm08&quot;  class=&quot;pc_img&quot; border=&quot;0&quot; /&gt;&lt;/a&gt;&lt;/span&gt;&lt;/div&gt;</message>
    </topic>
    <reply id="72157625163054214" author="41380738@N05" authorname="BlueRidgeKitties" role="member" iconserver="2459" iconfarm="3" can_edit="0" can_delete="0" datecreate="1287071539" lastedit="0">
      <message>*LOL* The universe is full of &lt;a href=&quot;http://www.flickr.com/groups/visualstory/discuss/72157622533160886/&quot;&gt;giant furry space monsters&lt;/a&gt; it seems! Love it.</message>
    </reply>
    <reply id="72157625163539300" author="52101018@N00" authorname="pterandon" role="admin" iconserver="1" iconfarm="1" can_edit="0" can_delete="0" datecreate="1287076748" lastedit="0">
      <message>Great work. Good focus on different aspects of scene in each frame.  Funny ending-- even better that I didn't notice the cat right away!  Being a hopeless Trekkie, I was wondering why Han was doing the Vulcan death grip on one of his allies....</message>
    </reply>
    <reply id="72157625040116805" author="54830408@N02" authorname="tay.grisham" role="member" iconserver="0" iconfarm="0" can_edit="0" can_delete="0" datecreate="1287089858" lastedit="0">
      <message>On a scale of 1 to 10 of awesome. This is a 15</message>
    </reply>
  </replies>
</rsp>
*/
			'parameters' => array(
				'topic_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.groups.discuss.replies.getList',
				),
			),
		),

// 41
		"flickr.groups.discuss.topics.add" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Post a new discussion topic to a group.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'group_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'subject'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'message'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.groups.discuss.topics.add',
				),
			),
		),

// 42
		"flickr.groups.discuss.topics.getInfo" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get information about a group discussion topic.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<?xml version="1.0" encoding="utf-8" ?>
<rsp stat="ok">
  <topic id="72157607082559966" subject="Who's still around?" author="30134652@N05" authorname="JAMAL'S ACCOUNT" is_pro="0" role="admin" iconserver="0" iconfarm="0" count_replies="1" can_edit="1" can_delete="0" can_reply="0" is_sticky="0" is_locked="0" datecreate="1337975869" datelastpost="1337975921" last_reply="72157607082559968">
    <message>Is anyone still around in this group?</message>
  </topic>
</rsp>
*/
			'parameters' => array(
				'topic_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.groups.discuss.topics.getInfo',
				),
			),
		),

// 43
		"flickr.groups.discuss.topics.getList" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get a list of discussion topics in a group.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<rsp stat="ok">
  <topics group_id="46744914@N00" iconserver="1" iconfarm="1" name="Tell a story in 5 frames (Visual story telling)" members="12428" privacy="3" lang="en-us" ispoolmoderated="1" total="4621" page="1" per_page="2" pages="2310">
    <topic id="72157625038324579" subject="A long time ago in a galaxy far, far away..." author="53930889@N04" authorname="Smallportfolio_jm08" role="member" iconserver="5169" iconfarm="6" count_replies="8" can_edit="0" can_delete="0" can_reply="0" is_sticky="0" is_locked="" datecreate="1287070965" datelastpost="1336905518">
      <message>&lt;div&gt;&lt;span class=&quot;photo_container pc_m bbml_img&quot;&gt;&lt;a href=&quot;/photos/53930889@N04/5080874079/&quot; title=&quot;Star Wars 1 by Smallportfolio_jm08&quot;&gt;&lt;img class=&quot;notsowide&quot; src=&quot;http://farm5.staticflickr.com/4035/5080874079_684cf874e0_m.jpg&quot; width=&quot;240&quot; height=&quot;180&quot; alt=&quot;Star Wars 1 by Smallportfolio_jm08&quot;  class=&quot;pc_img&quot; border=&quot;0&quot; /&gt;&lt;/a&gt;&lt;/span&gt;&lt;/div&gt;

&lt;div&gt;&lt;span class=&quot;photo_container pc_m bbml_img&quot;&gt;&lt;a href=&quot;/photos/53930889@N04/5081467846/&quot; title=&quot;Star Wars 2 by Smallportfolio_jm08&quot;&gt;&lt;img class=&quot;notsowide&quot; src=&quot;http://farm5.staticflickr.com/4071/5081467846_2eec86176d_m.jpg&quot; width=&quot;240&quot; height=&quot;180&quot; alt=&quot;Star Wars 2 by Smallportfolio_jm08&quot;  class=&quot;pc_img&quot; border=&quot;0&quot; /&gt;&lt;/a&gt;&lt;/span&gt;&lt;/div&gt;

&lt;div&gt;&lt;span class=&quot;photo_container pc_m bbml_img&quot;&gt;&lt;a href=&quot;/photos/53930889@N04/5081467886/&quot; title=&quot;Star Wars 3 by Smallportfolio_jm08&quot;&gt;&lt;img class=&quot;notsowide&quot; src=&quot;http://farm5.staticflickr.com/4021/5081467886_d8cca6c8e8_m.jpg&quot; width=&quot;240&quot; height=&quot;180&quot; alt=&quot;Star Wars 3 by Smallportfolio_jm08&quot;  class=&quot;pc_img&quot; border=&quot;0&quot; /&gt;&lt;/a&gt;&lt;/span&gt;&lt;/div&gt;

&lt;div&gt;&lt;span class=&quot;photo_container pc_m bbml_img&quot;&gt;&lt;a href=&quot;/photos/53930889@N04/5081467910/&quot; title=&quot;Star Wars 4 by Smallportfolio_jm08&quot;&gt;&lt;img class=&quot;notsowide&quot; src=&quot;http://farm5.staticflickr.com/4084/5081467910_274bb11fdc_m.jpg&quot; width=&quot;240&quot; height=&quot;180&quot; alt=&quot;Star Wars 4 by Smallportfolio_jm08&quot;  class=&quot;pc_img&quot; border=&quot;0&quot; /&gt;&lt;/a&gt;&lt;/span&gt;&lt;/div&gt;

&lt;div&gt;&lt;span class=&quot;photo_container pc_m bbml_img&quot;&gt;&lt;a href=&quot;/photos/53930889@N04/5081467948/&quot; title=&quot;Star Wars 5 by Smallportfolio_jm08&quot;&gt;&lt;img class=&quot;notsowide&quot; src=&quot;http://farm5.staticflickr.com/4154/5081467948_1a5f200bc0_m.jpg&quot; width=&quot;240&quot; height=&quot;180&quot; alt=&quot;Star Wars 5 by Smallportfolio_jm08&quot;  class=&quot;pc_img&quot; border=&quot;0&quot; /&gt;&lt;/a&gt;&lt;/span&gt;&lt;/div&gt;</message>
    </topic>
    <topic id="72157629635119774" subject="Where The Fish Are" author="75240402@N04" authorname="Nokinrocks" role="member" iconserver="7027" iconfarm="8" count_replies="0" can_edit="0" can_delete="0" can_reply="0" is_sticky="0" is_locked="" datecreate="1336485653" datelastpost="1336485653">
      <message>&lt;a href=&quot;http://www.flickr.com/photos/nokinrocks/7120495637/&quot;&gt;&lt;img class=&quot;notsowide&quot; src=&quot;http://farm9.staticflickr.com/8005/7120495637_fec0382b4b_n.jpg&quot; width=&quot;320&quot; height=&quot;256&quot; alt=&quot;Step It Up&quot; /&gt;&lt;/a&gt;

&lt;a href=&quot;http://www.flickr.com/photos/nokinrocks/7122908705/&quot;&gt;&lt;img class=&quot;notsowide&quot; src=&quot;http://farm8.staticflickr.com/7259/7122908705_3bef338378_n.jpg&quot; width=&quot;240&quot; height=&quot;320&quot; alt=&quot;P1050351&quot; /&gt;&lt;/a&gt;

&lt;a href=&quot;http://www.flickr.com/photos/nokinrocks/7122922123/&quot;&gt;&lt;img class=&quot;notsowide&quot; src=&quot;http://farm8.staticflickr.com/7052/7122922123_2bfcb6707c_n.jpg&quot; width=&quot;214&quot; height=&quot;320&quot; alt=&quot;Frog On A Log&quot; /&gt;&lt;/a&gt;

&lt;a href=&quot;http://www.flickr.com/photos/nokinrocks/7122929521/&quot;&gt;&lt;img class=&quot;notsowide&quot; src=&quot;http://farm8.staticflickr.com/7047/7122929521_8ffebdd424_n.jpg&quot; width=&quot;320&quot; height=&quot;200&quot; alt=&quot;P1050397&quot; /&gt;&lt;/a&gt;

&lt;a href=&quot;http://www.flickr.com/photos/nokinrocks/7122916999/&quot;&gt;&lt;img class=&quot;notsowide&quot; src=&quot;http://farm8.staticflickr.com/7200/7122916999_a7328f9dcc_n.jpg&quot; width=&quot;320&quot; height=&quot;261&quot; alt=&quot;P1050361&quot; /&gt;&lt;/a&gt;</message>
    </topic>
  </topics>
</rsp>
*/
			'parameters' => array(
				'group_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.groups.discuss.topics.getList',
				),
			),
		),

// 44
		"flickr.groups.getInfo" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get information about a group.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<group id="34427465497@N01" iconserver="1" iconfarm="1" lang="en-us" ispoolmoderated="0">
	<name>GNEverybody</name>
	<description>The group for GNE players</description>
	<members>69</members>
	<privacy>3</privacy>
	<throttle count="10" mode="month" remaining="3"/>
        <restrictions photos_ok="1" videos_ok="1" images_ok="1" screens_ok="1" art_ok="1" safe_ok="1" moderate_ok="0" restricted_ok="0" has_geo="0" />
</group>
*/
			'parameters' => array(
				'group_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'lang'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.groups.getInfo',
				),
			),
		),

// 45
		"flickr.groups.join" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Join a public group as a member.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'group_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'accept_rules'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.groups.join',
				),
			),
		),

// 46
		"flickr.groups.joinRequest" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Request to join a group that is invitation-only.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'group_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'message'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'accept_rules'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.groups.joinRequest',
				),
			),
		),

// 47
		"flickr.groups.leave" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Leave a group.

<br /><br />If the user is the only administrator left, and there are other members, the oldest member will be promoted to administrator.

<br /><br />If the user is the last person in the group, the group will be deleted.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'group_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'delete_photos'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.groups.leave',
				),
			),
		),

// 48
		"flickr.groups.members.getList" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get a list of the members of a group.  The call must be signed on behalf of a Flickr member, and the ability to see the group membership will be determined by the Flickr member\'s group privileges.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<members page="1" pages="1" perpage="100" total="33">
<member nsid="123456@N01" username="foo" iconserver="1" iconfarm="1" membertype="2"/>
<member nsid="118210@N07" username="kewlchops666" iconserver="0" iconfarm="0" membertype="4"/>
<member nsid="119377@N07" username="Alpha Shanan" iconserver="0" iconfarm="0" membertype="2"/>
<member nsid="67783977@N00" username="fakedunstanp1" iconserver="1003" iconfarm="2" membertype="3"/>
...
</members>
*/
			'parameters' => array(
				'group_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'membertypes'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.groups.members.getList',
				),
			),
		),

// 49
		"flickr.groups.pools.add" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Add a photo to a group\'s pool.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'group_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.groups.pools.add',
				),
			),
		),

// 50
		"flickr.groups.pools.getContext" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns next and previous photos for a photo in a group pool.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<prevphoto id="2980" secret="973da1e709"
	title="boo!" url="/photos/bees/2980/" /> 
<nextphoto id="2985" secret="059b664012"
	title="Amsterdam Amstel" url="/photos/bees/2985/" /> 
*/
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'group_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'num_prev'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'num_next'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'extras'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.groups.pools.getContext',
				),
			),
		),

// 51
		"flickr.groups.pools.getGroups" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns a list of groups to which you can add photos.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<groups page="1" pages="1" per_page="400" total="3">
	<group nsid="33853651696@N01" name="Art and Literature Hoedown"
		admin="0" privacy="3" photos="2" iconserver="1" /> 
	<group nsid="34427465446@N01" name="FlickrIdeas"
		admin="1" privacy="3" photos="20" iconserver="1" /> 
	<group nsid="34427465497@N01" name="GNEverybody"
		admin="0" privacy="3" photos="4" iconserver="1" /> 
</groups>
*/
			'parameters' => array(
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.groups.pools.getGroups',
				),
			),
		),

// 52
		"flickr.groups.pools.getPhotos" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns a list of pool photos for a given group, based on the permissions of the group and the user logged in (if any).',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<photos page="1" pages="1" perpage="1" total="1">
	<photo id="2645" owner="12037949754@N01" title="36679_o"
	secret="a9f4a06091" server="2"
	ispublic="1" isfriend="0" isfamily="0"
	ownername="Bees / ?" dateadded="1089918707" /> 
</photos>
*/
			'parameters' => array(
				'group_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'tags'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'user_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'jump_to'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'extras'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.groups.pools.getPhotos',
				),
			),
		),

// 53
		"flickr.groups.pools.remove" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Remove a photo from a group pool.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'group_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.groups.pools.remove',
				),
			),
		),

// 54
		"flickr.groups.search" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Search for groups. 18+ groups will only be returned for authenticated calls where the authenticated user is over 18.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<groups page="1" pages="14" perpage="5" total="67">
	<group nsid="3000@N02"
		name="Frito's Test Group" eighteenplus="0" /> 
	<group nsid="32825757@N00"
		name="Free for All" eighteenplus="0" /> 
	<group nsid="33335981560@N01"
		name="joly's mothers" eighteenplus="0" /> 
	<group nsid="33853651681@N01"
		name="Wintermute tower" eighteenplus="0" /> 
	<group nsid="33853651696@N01"
		name="Art and Literature Hoedown" eighteenplus="0" /> 
</groups>
*/
			'parameters' => array(
				'text'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.groups.search',
				),
			),
		),

// 55
		"flickr.interestingness.getList" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns the list of interesting photos for the most recent day or a user-specified date.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'use_panda'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'extras'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.interestingness.getList',
				),
			),
		),

// 56
		"flickr.machinetags.getNamespaces" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Return a list of unique namespaces, optionally limited by a given predicate, in alphabetical order.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<namespaces page="1" total="5" perpage="500" pages="1">
  <namespace usage="6538" predicates="13">aero</namespace>
  <namespace usage="9072" predicates="24">flickr</namespace>
  <namespace usage="670270" predicates="35">geo</namespace>
  <namespace usage="23903" predicates="36">taxonomy</namespace>
  <namespace usage="50449" predicates="4">upcoming</namespace>
</namespaces>

*/
			'parameters' => array(
				'predicate'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.machinetags.getNamespaces',
				),
			),
		),

// 57
		"flickr.machinetags.getPairs" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Return a list of unique namespace and predicate pairs, optionally limited by predicate or namespace, in alphabetical order.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<pairs page="1" total="1228" perpage="500" pages="3">
   <pair namespace="aero" predicate="airline" usage="1093">aero:airline</pair>
   <pair namespace="aero" predicate="icao" usage="4">aero:icao</pair>
   <pair namespace="aero" predicate="model" usage="1026">aero:model</pair>
   <pair namespace="aero" predicate="tail" usage="1048">aero:tail</pair>
</pairs>
*/
			'parameters' => array(
				'namespace'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'predicate'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.machinetags.getPairs',
				),
			),
		),

// 58
		"flickr.machinetags.getPredicates" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Return a list of unique predicates, optionally limited by a given namespace.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<predicates page="1" pages="1" total="3" perpage="500">
    <predicate usage="20" namespaces="1">elbow</predicate>
    <predicate usage="52" namespaces="2">face</predicate>
    <predicate usage="10" namespaces="1">hand</predicate>
</predicates>

*/
			'parameters' => array(
				'namespace'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.machinetags.getPredicates',
				),
			),
		),

// 59
		"flickr.machinetags.getRecentValues" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Fetch recently used (or created) machine tags values.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<values namespace="taxonomy" predicate="common" page="1" total="500" perpage="500" pages="1">
    <value usage="4" namespace="taxonomy" predicate="common"
           first_added="1244232796" last_added="1244232796">maui chaff flower</value>

    <!-- and so on... -->
</values>
*/
			'parameters' => array(
				'namespace'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'predicate'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'added_since'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.machinetags.getRecentValues',
				),
			),
		),

// 60
		"flickr.machinetags.getValues" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Return a list of unique values for a namespace and predicate.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<values namespace="upcoming" predicate="event" page="1" pages="1" total="3" perpage="500">
    <value usage="3">123</value>
    <value usage="1">456</value>
    <value usage="147">789</value>
</values>
*/
			'parameters' => array(
				'namespace'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'predicate'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'usage'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.machinetags.getValues',
				),
			),
		),

// 61
		"flickr.panda.getList" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Return a list of <a href="http://www.flickr.com/explore/panda">Flickr pandas</a>, from whom you can request photos using the <a href="/services/api/flickr.panda.getPhotos.htm">flickr.panda.getPhotos</a> API method.
<br/><br/>
More information about the pandas can be found on the <a href="http://code.flickr.com/blog/2009/03/03/panda-tuesday-the-history-of-the-panda-new-apis-explore-and-you/">dev blog</a>.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<pandas>
   <panda>ling ling</panda>
   <panda>hsing hsing</panda>
   <panda>wang wang</panda>
</pandas>
*/
			'parameters' => array(
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.panda.getList',
				),
			),
		),

// 62
		"flickr.panda.getPhotos" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Ask the <a href="http://www.flickr.com/explore/panda">Flickr Pandas</a> for a list of recent public (and "safe") photos.
<br/><br/>
More information about the pandas can be found on the <a href="http://code.flickr.com/blog/2009/03/03/panda-tuesday-the-history-of-the-panda-new-apis-explore-and-you/">dev blog</a>.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<photos interval="60000" lastupdate="1235765058272" total="120" panda="ling ling">
    <photo title="Shorebirds at Pillar Point" id="3313428913" secret="2cd3cb44cb"
        server="3609" farm="4" owner="72442527@N00" ownername="Pat Ulrich"/>
    <photo title="Battle of the sky" id="3313713993" secret="3f7f51500f"
        server="3382" farm="4" owner="10459691@N05" ownername="Sven Ericsson"/>
    <!-- and so on -->
</photos>
*/
			'parameters' => array(
				'panda_name'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'extras'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.panda.getPhotos',
				),
			),
		),

// 63
		"flickr.people.findByEmail" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Return a user\'s NSID, given their email address',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<user nsid="12037949632@N01">
	<username>Stewart</username> 
</user>
*/
			'parameters' => array(
				'find_email'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.people.findByEmail',
				),
			),
		),

// 64
		"flickr.people.findByUsername" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Return a user\'s NSID, given their username.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<user nsid="12037949632@N01">
	<username>Stewart</username> 
</user>
*/
			'parameters' => array(
				'username'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.people.findByUsername',
				),
			),
		),

// 65
		"flickr.people.getGroups" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns the list of groups a user is a member of.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<groups>
  <group nsid="17274427@N00" name="Cream of the Crop - Please read the rules" iconfarm="1" iconserver="1" admin="0" eighteenplus="0" invitation_only="0" members="11935" pool_count="12522" />
  <group nsid="20083316@N00" name="Apple" iconfarm="1" iconserver="1" admin="0" eighteenplus="0" invitation_only="0" members="11776" pool_count="62438" />
  <group nsid="34427469792@N01" name="FlickrCentral" iconfarm="1" iconserver="1" admin="0" eighteenplus="0" invitation_only="0" members="168055" pool_count="5280930" />
  <group nsid="37718678610@N01" name="Typography and Lettering" iconfarm="1" iconserver="1" admin="0" eighteenplus="0" invitation_only="0" members="17318" pool_count="130169" />
</groups>
*/
			'parameters' => array(
				'user_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'extras'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.people.getGroups',
				),
			),
		),

// 66
		"flickr.people.getInfo" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get information about a user.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<person nsid="12037949754@N01" ispro="0" iconserver="122" iconfarm="1">
	<username>bees</username>
	<realname>Cal Henderson</realname>
        <mbox_sha1sum>eea6cd28e3d0003ab51b0058a684d94980b727ac</mbox_sha1sum>
	<location>Vancouver, Canada</location>
	<photosurl>http://www.flickr.com/photos/bees/</photosurl> 
	<profileurl>http://www.flickr.com/people/bees/</profileurl> 
	<photos>
		<firstdate>1071510391</firstdate>
		<firstdatetaken>1900-09-02 09:11:24</firstdatetaken>
		<count>449</count>
	</photos>
</person>
*/
			'parameters' => array(
				'user_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'url'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'fb_connected'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.people.getInfo',
				),
			),
		),

// 67
		"flickr.people.getLimits" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns the photo and video limits that apply to the calling user account.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<person nsid="30135021@N05">
	<photos maxdisplaypx="1024" maxupload="15728640" />
	<videos maxduration="90" maxupload="157286400" />
</person>
*/
			'parameters' => array(
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.people.getLimits',
				),
			),
		),

// 68
		"flickr.people.getPhotos" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Return photos from the given user\'s photostream. Only photos visible to the calling user will be returned. This method must be authenticated; to return public photos for a user, use <a href="/services/api/flickr.people.getPublicPhotos.html">flickr.people.getPublicPhotos</a>.',
			'needsSigning' => true,
			"responseClass" => "Intahwebz\\FlickrGuzzle\\DTO\\PhotoList",
			'parameters' => array(
				'user_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'safe_search'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'min_upload_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'max_upload_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'min_taken_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'max_taken_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'content_type'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'privacy_filter'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'extras'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.people.getPhotos',
				),
			),
		),

// 69
		"flickr.people.getPhotosOf" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns a list of photos containing a particular Flickr member.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<photos page="2" has_next_page="1" perpage="10">
	<photo id="2636" owner="47058503995@N01" 
		secret="a123456" server="2" title="test_04"
		ispublic="1" isfriend="0" isfamily="0" />
	<photo id="2635" owner="47058503995@N01"
		secret="b123456" server="2" title="test_03"
		ispublic="0" isfriend="1" isfamily="1" />
	<photo id="2633" owner="47058503995@N01"
		secret="c123456" server="2" title="test_01"
		ispublic="1" isfriend="0" isfamily="0" />
	<photo id="2610" owner="12037949754@N01"
		secret="d123456" server="2" title="00_tall"
		ispublic="1" isfriend="0" isfamily="0" />
</photos>
*/
			'parameters' => array(
				'user_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'owner_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'extras'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.people.getPhotosOf',
				),
			),
		),

// 70
		"flickr.people.getPublicGroups" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns the list of public groups a user is a member of.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<groups>
	<group nsid="34427469792@N01" name="FlickrCentral"
		admin="0" eighteenplus="0" invitation_only="0" /> 
	<group nsid="37114057624@N01" name="Cal's Test Group"
		admin="1" eighteenplus="0" invitation_only="1" /> 
	<group nsid="34955637532@N01" name="18+ Group"
		admin="1" eighteenplus="1" invitation_only="0" /> 
</groups>
*/
			'parameters' => array(
				'user_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'invitation_only'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.people.getPublicGroups',
				),
			),
		),

// 71
		"flickr.people.getPublicPhotos" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get a list of public photos for the given user.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'user_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'safe_search'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'extras'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.people.getPublicPhotos',
				),
			),
		),

// 72
		"flickr.people.getUploadStatus" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns information for the calling user related to photo uploads.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<user id="12037949754@N01" ispro="1">
	<username>Bees</username> 
	<bandwidth
		maxbytes="2147483648" maxkb="2097152"
		usedbytes="383724" usedkb="374"
		remainingbytes="2147099924" remainingkb="2096777"
	 /> 
	<filesize
		maxbytes="10485760" maxkb="10240"
	/> 
	<sets
		created="27"
		remaining="lots"
	/>
	<videos
		uploaded="5"
		remaining="lots"
	/>
</user>
*/
			'parameters' => array(
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.people.getUploadStatus',
				),
			),
		),

// 73
		"flickr.photos.addTags" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Add tags to a photo.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'tags'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.addTags',
				),
			),
		),

// 74
		"flickr.photos.comments.addComment" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Add comment to a photo as the currently authenticated user.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<comment id="97777-72057594037941949-72057594037942602" />
*/
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'comment_text'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.comments.addComment',
				),
			),
		),

// 75
		"flickr.photos.comments.deleteComment" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Delete a comment as the currently authenticated user.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'comment_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.comments.deleteComment',
				),
			),
		),

// 76
		"flickr.photos.comments.editComment" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Edit the text of a comment as the currently authenticated user.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'comment_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'comment_text'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.comments.editComment',
				),
			),
		),

// 77
		"flickr.photos.comments.getList" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns the comments for a photo',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<comments photo_id="109722179">
        <comment id="6065-109722179-72057594077818641"
         author="35468159852@N01" authorname="Rev Dan Catt" datecreate="1141841470"
         permalink="http://www.flickr.com/photos/straup/109722179/#comment72057594077818641"
         >Umm, I'm not sure, can I get back to you on that one?</comment>
</comments>
*/
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'min_comment_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'max_comment_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'include_faves'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.comments.getList',
				),
			),
		),

// 78
		"flickr.photos.comments.getRecentForContacts" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Return the list of photos belonging to your contacts that have been commented on recently.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'date_lastcomment'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'contacts_filter'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'extras'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.comments.getRecentForContacts',
				),
			),
		),

// 79
		"flickr.photos.delete" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Delete a photo from flickr.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.delete',
				),
			),
		),

// 80
		"flickr.photos.geo.batchCorrectLocation" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Correct the places hierarchy for all the photos for a user at a given latitude, longitude and accuracy.<br /><br />

Batch corrections are processed in a delayed queue so it may take a few minutes before the changes are reflected in a user\'s photos.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'lat'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'lon'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'accuracy'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'place_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'woe_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.geo.batchCorrectLocation',
				),
			),
		),

// 81
		"flickr.photos.geo.correctLocation" => array(
			'extends' => 'defaultGetOperation',
			'summary' => '',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'place_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'woe_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'foursquare_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.geo.correctLocation',
				),
			),
		),

// 82
		"flickr.photos.geo.getLocation" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get the geo data (latitude and longitude and the accuracy level) for a photo.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<photo id="123">
        <location latitude="-17.685895" longitude="-63.36914" accuracy="6" />
</photo>
*/
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'extras'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.geo.getLocation',
				),
			),
		),

// 83
		"flickr.photos.geo.getPerms" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get permissions for who may view geo data for a photo.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<perms id="10592" ispublic="0" iscontact="0" isfriend="0" isfamily="1" />
*/
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.geo.getPerms',
				),
			),
		),

// 84
		"flickr.photos.geo.photosForLocation" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Return a list of photos for the calling user at a specific latitude, longitude and accuracy',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'lat'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'lon'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'accuracy'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'extras'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.geo.photosForLocation',
				),
			),
		),

// 85
		"flickr.photos.geo.removeLocation" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Removes the geo data associated with a photo.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.geo.removeLocation',
				),
			),
		),

// 86
		"flickr.photos.geo.setContext" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Indicate the state of a photo\'s geotagginess beyond latitude and longitude.<br /><br />
Note : photos passed to this method must already be geotagged (using the <q>flickr.photos.geo.setLocation</q> method).',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'context'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.geo.setContext',
				),
			),
		),

// 87
		"flickr.photos.geo.setLocation" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Sets the geo data (latitude and longitude and, optionally, the accuracy level) for a photo.

Before users may assign location data to a photo they must define who, by default, may view that information. Users can edit this preference at <a href="http://www.flickr.com/account/geo/privacy/">http://www.flickr.com/account/geo/privacy/</a>. If a user has not set this preference, the API method will return an error.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'lat'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'lon'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'accuracy'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'context'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'bookmark_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'is_public'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'is_contact'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'is_friend'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'is_family'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'foursquare_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'woeid'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.geo.setLocation',
				),
			),
		),

// 88
		"flickr.photos.geo.setPerms" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Set the permission for who may view the geo data associated with a photo.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'is_public'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'is_contact'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'is_friend'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'is_family'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.geo.setPerms',
				),
			),
		),

// 89
		"flickr.photos.getAllContexts" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns all visible sets and pools the photo belongs to.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<set id="392" title="记忆群组" />
<pool id="34427465471@N01" title="FlickrDiscuss" />
*/
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.getAllContexts',
				),
			),
		),

// 90
		"flickr.photos.getContactsPhotos" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Fetch a list of recent photos from the calling users contacts.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<photos>
	<photo id="2801" owner="12037949629@N01"
		secret="123456" server="1"
		username="Eric is the best" title="grease" /> 
	<photo id="2499" owner="33853651809@N01"
		secret="123456" server="1"
		username="cal18" title="36679_o" /> 
	<photo id="2437" owner="12037951898@N01"
		secret="123456" server="1"
		username="georgie parker" title="phoenix9_stewart" /> 
</photos>
*/
			'parameters' => array(
				'count'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'just_friends'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'single_photo'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'include_self'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'extras'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.getContactsPhotos',
				),
			),
		),

// 91
		"flickr.photos.getContactsPublicPhotos" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Fetch a list of recent public photos from a users\' contacts.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<photos>
	<photo id="2801" owner="12037949629@N01"
		secret="123456" server="1"
		username="Eric is the best" title="grease" /> 
	<photo id="2499" owner="33853651809@N01"
		secret="123456" server="1"
		username="cal18" title="36679_o" /> 
	<photo id="2437" owner="12037951898@N01"
		secret="123456" server="1"
		username="georgie parker" title="phoenix9_stewart" /> 
</photos>
*/
			'parameters' => array(
				'user_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'count'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'just_friends'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'single_photo'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'include_self'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'extras'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.getContactsPublicPhotos',
				),
			),
		),

// 92
		"flickr.photos.getContext" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns next and previous photos for a photo in a photostream.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<prevphoto id="2980" secret="973da1e709"
	title="boo!" url="/photos/bees/2980/" /> 
<nextphoto id="2985" secret="059b664012"
	title="Amsterdam Amstel" url="/photos/bees/2985/" /> 
*/
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'num_prev'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'num_next'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'extras'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'order_by'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.getContext',
				),
			),
		),

// 93
		"flickr.photos.getCounts" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Gets a list of photo counts for the given date ranges for the calling user.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<photocounts>
	<photocount count="4" fromdate="1093566950" todate="1093653350" /> 
	<photocount count="0" fromdate="1093653350" todate="1093739750" /> 
	<photocount count="0" fromdate="1093739750" todate="1093826150" /> 
	<photocount count="2" fromdate="1093826150" todate="1093912550" /> 
	<photocount count="0" fromdate="1093912550" todate="1093998950" /> 
	<photocount count="0" fromdate="1093998950" todate="1094085350" /> 
	<photocount count="0" fromdate="1094085350" todate="1094171750" /> 
</photocounts>

*/
			'parameters' => array(
				'dates'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'taken_dates'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.getCounts',
				),
			),
		),

// 94
		"flickr.photos.getExif" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Retrieves a list of EXIF/TIFF/GPS tags for a given photo. The calling user must have permission to view the photo.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<photo id="4424" secret="06b8e43bc7" server="2">
	<exif tagspace="TIFF" tagspaceid="1" tag="271" label="Manufacturer">
		<raw>Canon</raw>
	</exif>
	<exif tagspace="EXIF" tagspaceid="0" tag="33437" label="Aperture">
		<raw>90/10</raw>
		<clean>f/9</clean>
	</exif>
	<exif tagspace="GPS" tagspaceid="3" tag="4" label="Longitude">
		<raw>64/1, 42/1, 4414/100</raw>
		<clean>64° 42' 44.14"</clean>
	</exif>
</photo>

*/
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'secret'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.getExif',
				),
			),
		),

// 95
		"flickr.photos.getFavorites" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns the list of people who have favorited a given photo.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<photo id="1253576" secret="81b96be690" server="1" farm="1"
	page="1" pages="3" perpage="10" total="27">
	<person nsid="33939862@N00" username="Dementation" favedate="1166689690"/>
	<person nsid="49485425@N00" username="indigenous_prodigy" favedate="1166573724"/>
	<person nsid="46834205@N00" username="smaaz" favedate="1161874052"/>
	<person nsid="95626108@N00" username="chrome Foxpuppy" favedate="1160528154"/>
	<person nsid="44991966@N00" username="getnoid" favedate="1159828789"/>
	<person nsid="92544710@N00" username="miss_rogue" favedate="1158034266"/>
	<person nsid="50944224@N00" username="Infollatus" favedate="1155317436"/>
	<person nsid="80544408@N00" username="DafyddLlyr" favedate="1148511763"/>
	<person nsid="31154299@N00" username="c r i s" favedate="1143085224"/>
	<person nsid="54309070@N00" username="Shinayaker" favedate="1142584219"/>
</photo>
*/
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.getFavorites',
				),
			),
		),

// 96
		"flickr.photos.getInfo" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get information about a photo. The calling user must have permission to view the photo.',
			"responseClass" => "Intahwebz\\FlickrGuzzle\\DTO\\PhotoInfo",
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'secret'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'humandates'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'privacy_filter'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'get_contexts'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'get_geofences'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'extras'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.getInfo',
				),
			),
		),

// 97
		"flickr.photos.getNotInSet" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns a list of your photos that are not part of any sets.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'max_upload_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'min_taken_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'max_taken_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'privacy_filter'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'media'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'min_upload_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'extras'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.getNotInSet',
				),
			),
		),

// 98
		"flickr.photos.getPerms" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get permissions for a photo.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<perms id="2733" ispublic="1" isfriend="1" isfamily="0" permcomment="0" permaddmeta="1" /> 
*/
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.getPerms',
				),
			),
		),

// 99
		"flickr.photos.getRecent" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns a list of the latest public photos uploaded to flickr.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'jump_to'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'extras'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.getRecent',
				),
			),
		),

// 100
		"flickr.photos.getSizes" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns the available sizes for a photo.  The calling user must have permission to view the photo.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<sizes canblog="1" canprint="1" candownload="1">
    <size label="Square" width="75" height="75" source="http://farm2.staticflickr.com/1103/567229075_2cf8456f01_s.jpg" url="http://www.flickr.com/photos/stewart/567229075/sizes/sq/" media="photo" />
    <size label="Large Square" width="150" height="150" source="http://farm2.staticflickr.com/1103/567229075_2cf8456f01_q.jpg" url="http://www.flickr.com/photos/stewart/567229075/sizes/q/" media="photo" />
    <size label="Thumbnail" width="100" height="75" source="http://farm2.staticflickr.com/1103/567229075_2cf8456f01_t.jpg" url="http://www.flickr.com/photos/stewart/567229075/sizes/t/" media="photo" />
    <size label="Small" width="240" height="180" source="http://farm2.staticflickr.com/1103/567229075_2cf8456f01_m.jpg" url="http://www.flickr.com/photos/stewart/567229075/sizes/s/" media="photo" />
    <size label="Small 320" width="320" height="240" source="http://farm2.staticflickr.com/1103/567229075_2cf8456f01_n.jpg" url="http://www.flickr.com/photos/stewart/567229075/sizes/n/" media="photo" />
    <size label="Medium" width="500" height="375" source="http://farm2.staticflickr.com/1103/567229075_2cf8456f01.jpg" url="http://www.flickr.com/photos/stewart/567229075/sizes/m/" media="photo" />
    <size label="Medium 640" width="640" height="480" source="http://farm2.staticflickr.com/1103/567229075_2cf8456f01_z.jpg?zz=1" url="http://www.flickr.com/photos/stewart/567229075/sizes/z/" media="photo" />
    <size label="Medium 800" width="800" height="600" source="http://farm2.staticflickr.com/1103/567229075_2cf8456f01_c.jpg" url="http://www.flickr.com/photos/stewart/567229075/sizes/c/" media="photo" />
    <size label="Large" width="1024" height="768" source="http://farm2.staticflickr.com/1103/567229075_2cf8456f01_b.jpg" url="http://www.flickr.com/photos/stewart/567229075/sizes/l/" media="photo" />
    <size label="Original" width="2400" height="1800" source="http://farm2.staticflickr.com/1103/567229075_6dc09dc6da_o.jpg" url="http://www.flickr.com/photos/stewart/567229075/sizes/o/" media="photo" />
</sizes>

*/
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.getSizes',
				),
			),
		),

// 101
		"flickr.photos.getUntagged" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns a list of your photos with no tags.',
			'needsSigning' => true,
			"responseClass" => "Intahwebz\\FlickrGuzzle\\DTO\\PhotoList",
			'parameters' => array(
				'min_upload_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'max_upload_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'min_taken_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'max_taken_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'privacy_filter'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'media'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'extras'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.getUntagged',
				),
			),
		),

// 102
		"flickr.photos.getWithGeoData" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns a list of your geo-tagged photos.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'min_upload_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'max_upload_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'min_taken_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'max_taken_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'privacy_filter'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'sort'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'media'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'extras'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.getWithGeoData',
				),
			),
		),

// 103
		"flickr.photos.getWithoutGeoData" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns a list of your photos which haven\'t been geo-tagged.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'max_upload_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'min_taken_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'max_taken_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'privacy_filter'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'sort'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'media'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'min_upload_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'extras'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.getWithoutGeoData',
				),
			),
		),

// 104
		"flickr.photos.licenses.getInfo" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Fetches a list of available photo licenses for Flickr.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<licenses>
        <license id="0" name="All Rights Reserved" url="" />
	<license id="1" name="Attribution-NonCommercial-ShareAlike License"
		url="http://creativecommons.org/licenses/by-nc-sa/2.0/" /> 
	<license id="2" name="Attribution-NonCommercial License"
		url="http://creativecommons.org/licenses/by-nc/2.0/" /> 
	<license id="3" name="Attribution-NonCommercial-NoDerivs License"
		url="http://creativecommons.org/licenses/by-nc-nd/2.0/" /> 
	<license id="4" name="Attribution License"
		url="http://creativecommons.org/licenses/by/2.0/" /> 
	<license id="5" name="Attribution-ShareAlike License"
		url="http://creativecommons.org/licenses/by-sa/2.0/" /> 
	<license id="6" name="Attribution-NoDerivs License"
		url="http://creativecommons.org/licenses/by-nd/2.0/" /> 
	<license id="7" name="No known copyright restrictions"
		url="http://flickr.com/commons/usage/" />
        <license id="8" name="United States Government Work"
                url="http://www.usa.gov/copyright.shtml" />
</licenses>
*/
			'parameters' => array(
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.licenses.getInfo',
				),
			),
		),

// 105
		"flickr.photos.licenses.setLicense" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Sets the license for a photo.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'license_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.licenses.setLicense',
				),
			),
		),

// 106
		"flickr.photos.notes.add" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Add a note to a photo. Coordinates and sizes are in pixels, based on the 500px image size shown on individual photo pages.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<note id="1234" />
*/
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'note_x'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'note_y'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'note_w'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'note_h'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'note_text'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.notes.add',
				),
			),
		),

// 107
		"flickr.photos.notes.delete" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Delete a note from a photo.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'note_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.notes.delete',
				),
			),
		),

// 108
		"flickr.photos.notes.edit" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Edit a note on a photo. Coordinates and sizes are in pixels, based on the 500px image size shown on individual photo pages.
',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'note_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'note_x'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'note_y'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'note_w'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'note_h'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'note_text'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.notes.edit',
				),
			),
		),

// 109
		"flickr.photos.people.add" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Add a person to a photo. Coordinates and sizes of boxes are optional; they are measured in pixels, based on the 500px image size shown on individual photo pages.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'user_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'person_x'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'person_y'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'person_w'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'person_h'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.people.add',
				),
			),
		),

// 110
		"flickr.photos.people.delete" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Remove a person from a photo.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'user_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'email'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.people.delete',
				),
			),
		),

// 111
		"flickr.photos.people.deleteCoords" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Remove the bounding box from a person in a photo',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'user_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.people.deleteCoords',
				),
			),
		),

// 112
		"flickr.photos.people.editCoords" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Edit the bounding box of an existing person on a photo.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'user_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'person_x'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'person_y'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'person_w'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'person_h'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'email'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.people.editCoords',
				),
			),
		),

// 113
		"flickr.photos.people.getList" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get a list of people in a given photo.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<people total="1">
  <person nsid="87944415@N00" username="hitherto" iconserver="1" iconfarm="1"
          realname="Simon Batistoni" added_by="12037949754@N01" x="50" y="50"
          w="100" h="100"/>
</people>
*/
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.people.getList',
				),
			),
		),

// 114
		"flickr.photos.recentlyUpdated" => array(
			'extends' => 'defaultGetOperation',
			'summary' => '<p>Return a list of your photos that have been recently created or which have been recently modified.</p>

<p>Recently modified may mean that the photo\'s metadata (title, description, tags) may have been changed or a comment has been added (or just modified somehow :-)</p>',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<photos page="1" pages="1" perpage="100" total="2">
        <photo id="169885459" owner="35034348999@N01" 
               secret="c85114c195" server="46" title="Doubting Michael"
               ispublic="1" isfriend="0" isfamily="0" lastupdate="1150755888" />
        <photo id="85022332" owner="35034348999@N01"
               secret="23de6de0c0" server="41"
               title="&quot;Do you think we're allowed to tape stuff to the walls?&quot;"
               ispublic="1" isfriend="0" isfamily="0" lastupdate="1150564974" />
</photos>
*/
			'parameters' => array(
				'min_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'extras'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.recentlyUpdated',
				),
			),
		),

// 115
		"flickr.photos.removeTag" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Remove a tag from a photo.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'tag_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.removeTag',
				),
			),
		),

// 116
		"flickr.photos.search" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Return a list of photos matching some criteria. Only photos visible to the calling user will be returned. To return private or semi-private photos, the caller must be authenticated with read permissions, and have permission to view the photos. Unauthenticated calls will only return public photos.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'user_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'tags'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'tag_mode'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'text'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'min_upload_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'max_upload_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'min_taken_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'max_taken_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'license'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'sort'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'privacy_filter'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'bbox'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'accuracy'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'safe_search'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'content_type'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'machine_tags'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'machine_tag_mode'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'group_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'faves'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'camera'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'jump_to'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'contacts'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'woe_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'place_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'media'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'has_geo'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'geo_context'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'lat'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'lon'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'radius'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'radius_units'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'is_commons'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'in_gallery'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'person_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'is_getty'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'extras'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.search',
				),
			),
		),

// 117
		"flickr.photos.setContentType" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Set the content type of a photo.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<rsp stat="ok">
<photo id="14814" content_type="3"/>
</rsp>
*/
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'content_type'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.setContentType',
				),
			),
		),

// 118
		"flickr.photos.setDates" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Set one or both of the dates for a photo.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'date_posted'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'date_taken'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'date_taken_granularity'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.setDates',
				),
			),
		),

// 119
		"flickr.photos.setMeta" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Set the meta information for a photo.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'title'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'description'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.setMeta',
				),
			),
		),

// 120
		"flickr.photos.setPerms" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Set permissions for a photo.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<photoid secret="abcdef" originalsecret="abcdef">1234</photoid>
*/
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'is_public'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'is_friend'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'is_family'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'perm_comment'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'perm_addmeta'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.setPerms',
				),
			),
		),

// 121
		"flickr.photos.setSafetyLevel" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Set the safety level of a photo.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<rsp stat="ok">
<photo id="14814" safety_level="2" hidden="0"/>
</rsp>
*/
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'safety_level'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'hidden'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.setSafetyLevel',
				),
			),
		),

// 122
		"flickr.photos.setTags" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Set the tags for a photo.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'tags'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.setTags',
				),
			),
		),

// 123
		"flickr.photos.suggestions.approveSuggestion" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Approve a suggestion for a photo.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'suggestion_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.suggestions.approveSuggestion',
				),
			),
		),

// 124
		"flickr.photos.suggestions.getList" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Return a list of suggestions for a user that are pending approval.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'status_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.suggestions.getList',
				),
			),
		),

// 125
		"flickr.photos.suggestions.rejectSuggestion" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Reject a suggestion for a photo.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'suggestion_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.suggestions.rejectSuggestion',
				),
			),
		),

// 126
		"flickr.photos.suggestions.removeSuggestion" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Remove a suggestion, made by the calling user, from a photo.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'suggestion_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.suggestions.removeSuggestion',
				),
			),
		),

// 127
		"flickr.photos.suggestions.suggestLocation" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Suggest a geotagged location for a photo.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'lat'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'lon'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'accuracy'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'woe_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'place_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'note'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.suggestions.suggestLocation',
				),
			),
		),

// 128
		"flickr.photos.transform.rotate" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Rotate a photo.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<photoid secret="abcdef" originalsecret="abcdef">1234</photoid>
*/
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'degrees'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.transform.rotate',
				),
			),
		),

// 129
		"flickr.photos.upload.checkTickets" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Checks the status of one or more asynchronous photo upload tickets.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<uploader>
	<ticket id="128" complete="1" photoid="2995" />
	<ticket id="129" complete="0" />
	<ticket id="130" complete="2" />
	<ticket id="131" invalid="1" />
</uploader>

*/
			'parameters' => array(
				'tickets'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'batch_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photos.upload.checkTickets',
				),
			),
		),

// 130
		"flickr.photosets.addPhoto" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Add a photo to the end of an existing photoset.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'photoset_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photosets.addPhoto',
				),
			),
		),

// 131
		"flickr.photosets.comments.addComment" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Add a comment to a photoset.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<comment id="97777-12492-72057594037942601" />
*/
			'parameters' => array(
				'photoset_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'comment_text'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photosets.comments.addComment',
				),
			),
		),

// 132
		"flickr.photosets.comments.deleteComment" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Delete a photoset comment as the currently authenticated user.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'comment_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photosets.comments.deleteComment',
				),
			),
		),

// 133
		"flickr.photosets.comments.editComment" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Edit the text of a comment as the currently authenticated user.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'comment_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'comment_text'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photosets.comments.editComment',
				),
			),
		),

// 134
		"flickr.photosets.comments.getList" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns the comments for a photoset.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<comments photoset_id="109722179">
    <comment id="6065-109722179-72057594077818641"
         author="35468159852@N01" authorname="Rev Dan Catt" date_create="1141841470"
         permalink="http://www.flickr.com/photos/straup/109722179/#comment72057594077818641"
         >Umm, I'm not sure, can I get back to you on that one?</comment>
</comments>
*/
			'parameters' => array(
				'photoset_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photosets.comments.getList',
				),
			),
		),

// 135
		"flickr.photosets.create" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Create a new photoset for the calling user.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<photoset id="1234" url="http://www.flickr.com/photos/bees/sets/1234/" />
*/
			'parameters' => array(
				'title'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'description'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'primary_photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photosets.create',
				),
			),
		),

// 136
		"flickr.photosets.delete" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Delete a photoset.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'photoset_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photosets.delete',
				),
			),
		),

// 137
		"flickr.photosets.editMeta" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Modify the meta-data for a photoset.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'photoset_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'title'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'description'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photosets.editMeta',
				),
			),
		),

// 138
		"flickr.photosets.editPhotos" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Modify the photos in a photoset. Use this method to add, remove and re-order photos.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'photoset_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'primary_photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'photo_ids'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photosets.editPhotos',
				),
			),
		),

// 139
		"flickr.photosets.getContext" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns next and previous photos for a photo in a set.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<prevphoto id="2980" secret="973da1e709"
	title="boo!" url="/photos/bees/2980/" /> 
<nextphoto id="2985" secret="059b664012"
	title="Amsterdam Amstel" url="/photos/bees/2985/" /> 
*/
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'photoset_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'num_prev'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'num_next'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'extras'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photosets.getContext',
				),
			),
		),

// 140
		"flickr.photosets.getInfo" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Gets information about a photoset.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<photoset id="72157624618609504" owner="34427469121@N01" primary="4847770787" secret="6abd09a292" server="4153" farm="5" photos="55" count_views="523" count_comments="1" count_photos="43" count_videos="12" can_comment="1" date_create="1280530593" date_update="1308091378">
    <title>Mah Kittehs</title>
    <description>Sixty and Niner. Born on the 3rd of May, 2010, or thereabouts. Came to my place on Thursday, July 29, 2010.</description>
</photoset>
*/
			'parameters' => array(
				'photoset_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photosets.getInfo',
				),
			),
		),

// 141
		"flickr.photosets.getList" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns the photosets belonging to the specified user.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<photosets page="1" pages="1" perpage="30" total="2" cancreate="1">
    <photoset id="72157626216528324" primary="5504567858" secret="017804c585" server="5174" farm="6" photos="22" videos="0" count_views="137" count_comments="0" can_comment="1" date_create="1299514498" date_update="1300335009">
      <title>Avis Blanche</title>
      <description>My Grandma's Recipe File.</description>
    </photoset>
    <photoset id="72157624618609504" primary="4847770787" secret="6abd09a292" server="4153" farm="5" photos="43" videos="12" count_views="523" count_comments="1" can_comment="1" date_create="1280530593" date_update="1308091378">
      <title>Mah Kittehs</title>
      <description>Sixty and Niner. Born on the 3rd of May, 2010, or thereabouts. Came to my place on Thursday, July 29, 2010.</description>
    </photoset>
</photosets>
*/
			'parameters' => array(
				'user_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photosets.getList',
				),
			),
		),

// 142
		"flickr.photosets.getPhotos" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get the list of photos in a set.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<photoset id="4" primary="2483" page="1" perpage="500" pages="1" total="2">
	<photo id="2484" secret="123456" server="1"
		title="my photo" isprimary="0" /> 
	<photo id="2483" secret="123456" server="1"
		title="flickr rocks" isprimary="1" /> 
</photoset>
*/
			'parameters' => array(
				'photoset_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'extras'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'privacy_filter'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'media'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photosets.getPhotos',
				),
			),
		),

// 143
		"flickr.photosets.orderSets" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Set the order of photosets for the calling user.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'photoset_ids'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photosets.orderSets',
				),
			),
		),

// 144
		"flickr.photosets.removePhoto" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Remove a photo from a photoset.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'photoset_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photosets.removePhoto',
				),
			),
		),

// 145
		"flickr.photosets.removePhotos" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Remove multiple photos from a photoset.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'photoset_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'photo_ids'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photosets.removePhotos',
				),
			),
		),

// 146
		"flickr.photosets.reorderPhotos" => array(
			'extends' => 'defaultGetOperation',
			'summary' => '',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'photoset_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'photo_ids'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photosets.reorderPhotos',
				),
			),
		),

// 147
		"flickr.photosets.setPrimaryPhoto" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Set photoset primary photo',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'photoset_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.photosets.setPrimaryPhoto',
				),
			),
		),

// 148
		"flickr.places.find" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Return a list of place IDs for a query string.<br /><br />
The flickr.places.find method is <b>not</b> a geocoder. It will round <q>up</q> to the nearest place type to which place IDs apply. For example, if you pass it a street level address it will return the city that contains the address rather than the street, or building, itself.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<places query="Alabama" total="3">
   <place place_id="VrrjuESbApjeFS4." woeid="2347559"
               latitude="32.614" longitude="-86.680"
               place_url="/United+States/Alabama"
               place_type="region">Alabama, Alabama, United States</place>
   <place place_id="cGHuc0mbApmzEHoP" woeid="2352520"
               latitude="43.096" longitude="-78.389"
               place_url="/United+States/New+York/Alabama"
               place_type="locality">Alabama, New York, United States</place>
   <place place_id="o4yVPEqYBJvFMP8Q" woeid="1579389"
               latitude="-26.866" longitude="26.583"
               place_url="/South+Africa/North+West/Alabama"
               place_type="locality">Alabama, North West, South Africa</place>
</places>
*/
			'parameters' => array(
				'query'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'bbox'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'extras'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'safe'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.places.find',
				),
			),
		),

// 149
		"flickr.places.findByLatLon" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Return a place ID for a latitude, longitude and accuracy triple.<br /><br />
The flickr.places.findByLatLon method is not meant to be a (reverse) geocoder in the traditional sense. It is designed to allow users to find photos for "places" and will round up to the nearest place type to which corresponding place IDs apply.<br /><br />
For example, if you pass it a street level coordinate it will return the city that contains the point rather than the street, or building, itself.<br /><br />
It will also truncate latitudes and longitudes to three decimal points.

',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<places latitude="37.76513627957266" longitude="-122.42020770907402" accuracy="16" total="1">
   <place place_id="Y12JWsKbApmnSQpbQg" woeid="23512048"
      latitude="37.765" longitude="-122.424" 
      place_url="/United+States/California/San+Francisco/Mission+Dolores"
      place_type="neighbourhood" place_type_id="22" 
      timezone="America/Los_Angeles"
      name="Mission Dolores, San Francisco, CA, US, United States"/>
</places>
*/
			'parameters' => array(
				'lat'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'lon'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'accuracy'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.places.findByLatLon',
				),
			),
		),

// 150
		"flickr.places.getChildrenWithPhotosPublic" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Return a list of locations with public photos that are parented by a Where on Earth (WOE) or Places ID.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<places total="79">
   <place place_id="HznQfdKbB58biy8sdA" woeid="26332794"
      latitude="45.498" longitude="-73.575"
      place_url="/Canada/Quebec/Montreal  /Montreal+Golden+Square+Mile"
      place_type="neighbourhood" photo_count="2717">
      Montreal Golden Square Mile, Montreal, QC, CA, Canada
   </place>
   <place place_id="K1rYWmGbB59rwn7lOA" woeid="26332799"
      latitude="45.502" longitude="-73.578"
      place_url="/Canada/Quebec/Montreal/Downtown+Montr%C3%A9al"
      place_type="neighbourhood" photo_count="2317">
      Downtown Montréal, Montreal, QC, CA, Canada
  </place>

   <!-- and so on... -->

</places>
*/
			'parameters' => array(
				'place_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'woe_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.places.getChildrenWithPhotosPublic',
				),
			),
		),

// 151
		"flickr.places.getInfo" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get informations about a place.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<place place_id="4hLQygSaBJ92" woeid="3534"
   latitude="45.512" longitude="-73.554"
   place_url="/Canada/Quebec/Montreal" place_type="locality"
   has_shapedata="1" timezone="America/Toronto">
   <locality place_id="4hLQygSaBJ92" woeid="3534"
      latitude="45.512" longitude="-73.554"
      place_url="/Canada/Quebec/Montreal">Montreal</locality>
   <county place_id="cFBi9x6bCJ8D5rba1g" woeid="29375198"
      latitude="45.551" longitude="-73.600" 
      place_url="/cFBi9x6bCJ8D5rba1g">Montréal</county>
   <region place_id="CrZUvXebApjI0.72" woeid="2344924" 
      latitude="53.890" longitude="-68.429"
      place_url="/Canada/Quebec">Quebec</region>
   <country place_id="EESRy8qbApgaeIkbsA" woeid="23424775"
      latitude="62.358" longitude="-96.582" 
      place_url="/Canada">Canada</country>
   <shapedata created="1223513357" alpha="0.012359619140625"
      count_points="34778" count_edges="52"
      has_donuthole="1" is_donuthole="1">
      <polylines>
         <polyline>
            45.427627563477,-73.589645385742 45.428966522217,-73.587898254395, etc...
         </polyline>
      </polylines>
      <urls>
         <shapefile>
         http://farm4.static.flickr.com/3228/shapefiles/3534_20081111_0a8afe03c5.tar.gz
         </shapefile>
      </urls>
   </shapedata>
</place>
*/
			'parameters' => array(
				'place_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'woe_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.places.getInfo',
				),
			),
		),

// 152
		"flickr.places.getInfoByUrl" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Lookup information about a place, by its flickr.com/places URL.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<place place_id="4hLQygSaBJ92" woeid="3534"
   latitude="45.512" longitude="-73.554"
   place_url="/Canada/Quebec/Montreal" place_type="locality"
   has_shapedata="1">
   <locality place_id="4hLQygSaBJ92" woeid="3534"
      latitude="45.512" longitude="-73.554"
      place_url="/Canada/Quebec/Montreal">Montreal</locality>
   <county place_id="cFBi9x6bCJ8D5rba1g" woeid="29375198"
      latitude="45.551" longitude="-73.600" 
      place_url="/cFBi9x6bCJ8D5rba1g">Montréal</county>
   <region place_id="CrZUvXebApjI0.72" woeid="2344924" 
      latitude="53.890" longitude="-68.429"
      place_url="/Canada/Quebec">Quebec</region>
   <country place_id="EESRy8qbApgaeIkbsA" woeid="23424775"
      latitude="62.358" longitude="-96.582" 
      place_url="/Canada">Canada</country>
   <shapedata created="1223513357" alpha="0.012359619140625"
      count_points="34778" count_edges="52">
      <polylines>
         <polyline>
            45.427627563477,-73.589645385742 45.428966522217,-73.587898254395, etc...
         </polyline>
      </polylines>
   </shapedata>
</place>
*/
			'parameters' => array(
				'url'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.places.getInfoByUrl',
				),
			),
		),

// 153
		"flickr.places.getPlaceTypes" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Fetches a list of available place types for Flickr.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<place_types>
   <place_type place_type_id="22">neighbourhood</place_type>
   <place_type place_type_id="7">locality</place_type>
   <place_type place_type_id="9">county</place_type>
   <place_type place_type_id="8">region</place_type>
   <place_type place_type_id="12">country</place_type>
   <place_type place_type_id="29">continent</place_type>
</place_types>
*/
			'parameters' => array(
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.places.getPlaceTypes',
				),
			),
		),

// 154
		"flickr.places.getShapeHistory" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Return an historical list of all the shape data generated for a Places or Where on Earth (WOE) ID.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<shapes total="2" woe_id="3534" place_id="4hLQygSaBJ92" place_type="locality" place_type_id="7">
   <shapedata created="1223513357" alpha="0.012359619140625"
      count_points="34778" count_edges="52" is_donuthole="0">
      <polylines>
         <polyline>
            45.427627563477,-73.589645385742 45.428966522217,-73.587898254395, etc...
         </polyline>
      </polylines>
      <urls>
         <shapefile>
         http://farm4.static.flickr.com/3228/shapefiles/3534_20081111_0a8afe03c5.tar.gz
         </shapefile>
      </urls>
   </shapedata>
   <!-- and so on... -->
</shapes>
*/
			'parameters' => array(
				'place_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'woe_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.places.getShapeHistory',
				),
			),
		),

// 155
		"flickr.places.getTopPlacesList" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Return the top 100 most geotagged places for a day.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<places total="100" date_start="1246320000" date_stop="1246406399">
   <place place_id="4KO02SibApitvSBieQ" woeid="23424977"
       latitude="48.890" longitude="-116.982" 
       place_url="/United+States" place_type="country" 
       place_type_id="12" photo_count="23371">United States</place>
   <!-- and so on... -->
</places>
*/
			'parameters' => array(
				'place_type_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'woe_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'place_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.places.getTopPlacesList',
				),
			),
		),

// 156
		"flickr.places.placesForBoundingBox" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Return all the locations of a matching place type for a bounding box.<br /><br />

The maximum allowable size of a bounding box (the distance between the SW and NE corners) is governed by the place type you are requesting. Allowable sizes are as follows:

<ul>
<li><strong>neighbourhood</strong>: 3km (1.8mi)</li>
<li><strong>locality</strong>: 7km (4.3mi)</li>
<li><strong>county</strong>: 50km (31mi)</li>
<li><strong>region</strong>: 200km (124mi)</li>
<li><strong>country</strong>: 500km (310mi)</li>
<li><strong>continent</strong>: 1500km (932mi)</li>
</ul>',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<places place_type="neighbourhood" total="21"
   pages="1" page="1" 
   bbox="-122.42307100000001,37.773779,-122.381071,37.815779">
   <place place_id=".aaSwYSbApnq6seyGw" woeid="23512025"
      latitude="37.788" longitude="-122.412" 
      place_url="/United+States/California/San+Francisco/Downtown"
      place_type="neighbourhood">
      Downtown, San Francisco, CA, US, United States
   </place>
   <place place_id="3KymK1GbCZ41eBVBxg" woeid="28288707"
      latitude="37.776" longitude="-122.417" 
      place_url="/United+States/California/San+Francisco/Civic+Center"
      place_type="neighbourhood">
      Civic Center, San Francisco, CA, US, United States
   </place>
   <place place_id="9xdhxY.bAptvBjHo" woeid="2379855"   
      latitude="37.796" longitude="-122.407" 
      place_url="/United+States/California/San+Francisco/Chinatown"
      place_type="neighbourhood">
      Chinatown, San Francisco, CA, US, United States
   </place>
   <!-- and so on -->
</places>
*/
			'parameters' => array(
				'bbox'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'place_type'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'place_type_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'recursive'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.places.placesForBoundingBox',
				),
			),
		),

// 157
		"flickr.places.placesForContacts" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Return a list of the top 100 unique places clustered by a given placetype for a user\'s contacts. ',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<places total="1">
   <place place_id="kH8dLOubBZRvX_YZ" woeid="2487956"
               latitude="37.779" longitude="-122.420"
               place_url="/United+States/California/San+Francisco"
               place_type="locality"
               photo_count="156">San Francisco, California</place>
</places>
*/
			'parameters' => array(
				'place_type'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'place_type_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'woe_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'place_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'threshold'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'contacts'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'min_upload_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'max_upload_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'min_taken_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'max_taken_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.places.placesForContacts',
				),
			),
		),

// 158
		"flickr.places.placesForTags" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Return a list of the top 100 unique places clustered by a given placetype for set of tags or machine tags. ',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<places total="1">
   <place place_id="kH8dLOubBZRvX_YZ" woeid="2487956"
               latitude="37.779" longitude="-122.420"
               place_url="/United+States/California/San+Francisco"
               place_type="locality"
               photo_count="156">San Francisco, California</place>
</places>
*/
			'parameters' => array(
				'place_type_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'woe_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'place_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'threshold'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'tags'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'tag_mode'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'machine_tags'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'machine_tag_mode'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'min_upload_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'max_upload_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'min_taken_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'max_taken_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.places.placesForTags',
				),
			),
		),

// 159
		"flickr.places.placesForUser" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Return a list of the top 100 unique places clustered by a given placetype for a user. ',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<places total="1">
   <place place_id="kH8dLOubBZRvX_YZ" woeid="2487956"
               latitude="37.779" longitude="-122.420"
               place_url="/United+States/California/San+Francisco"
               place_type="locality"
               photo_count="156">San Francisco, California</place>
</places>
*/
			'parameters' => array(
				'place_type_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'place_type'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'woe_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'place_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'threshold'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'min_upload_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'max_upload_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'min_taken_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'max_taken_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.places.placesForUser',
				),
			),
		),

// 160
		"flickr.places.resolvePlaceId" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Find Flickr Places information by Place ID.<br /><br />
This method has been deprecated. It won\'t be removed but you should use <a href="/services/api/flickr.places.getInfo.html">flickr.places.getInfo</a> instead.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<location place_id="kH8dLOubBZRvX_YZ" woeid="2487956" 
                latitude="37.779" longitude="-122.420"
                place_url="/United+States/California/San+Francisco"
                place_type="locality">
   <locality place_id="kH8dLOubBZRvX_YZ" woeid="2487956"
                 latitude="37.779" longitude="-122.420" 
                 place_url="/United+States/California/San+Francisco">San Francisco</locality>
   <county place_id="hCca8XSYA5nn0X1Sfw" woeid="12587707"
                 latitude="37.759" longitude="-122.435" 
                 place_url="/hCca8XSYA5nn0X1Sfw">San Francisco</county>
   <region place_id="SVrAMtCbAphCLAtP" woeid="2347563" 
                latitude="37.271" longitude="-119.270" 
                place_url="/United+States/California">California</region>
   <country place_id="4KO02SibApitvSBieQ" woeid="23424977"
                  latitude="48.890" longitude="-116.982" 
                  place_url="/United+States">United States</country>
</location>
*/
			'parameters' => array(
				'place_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.places.resolvePlaceId',
				),
			),
		),

// 161
		"flickr.places.resolvePlaceURL" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Find Flickr Places information by Place URL.<br /><br />
This method has been deprecated. It won\'t be removed but you should use <a href="/services/api/flickr.places.getInfoByUrl.html">flickr.places.getInfoByUrl</a> instead.
',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<location place_id="kH8dLOubBZRvX_YZ" woeid="2487956" 
                latitude="37.779" longitude="-122.420"
                place_url="/United+States/California/San+Francisco"
                place_type="locality">
   <locality place_id="kH8dLOubBZRvX_YZ" woeid="2487956"
                 latitude="37.779" longitude="-122.420" 
                 place_url="/United+States/California/San+Francisco">San Francisco</locality>
   <county place_id="hCca8XSYA5nn0X1Sfw" woeid="12587707"
                 latitude="37.759" longitude="-122.435" 
                 place_url="/hCca8XSYA5nn0X1Sfw">San Francisco</county>
   <region place_id="SVrAMtCbAphCLAtP" woeid="2347563" 
                latitude="37.271" longitude="-119.270" 
                place_url="/United+States/California">California</region>
   <country place_id="4KO02SibApitvSBieQ" woeid="23424977"
                  latitude="48.890" longitude="-116.982" 
                  place_url="/United+States">United States</country>
</location>
*/
			'parameters' => array(
				'url'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.places.resolvePlaceURL',
				),
			),
		),

// 162
		"flickr.places.tagsForPlace" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Return a list of the top 100 unique tags for a Flickr Places or Where on Earth (WOE) ID',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<tags total="100">
   <tag count="31775">montreal</tag>
   <tag count="20585">canada</tag>
   <tag count="12319">montréal</tag>
   <tag count="12154">quebec</tag>
   <tag count="6471">québec</tag>
   <tag count="2173">sylvainmichaud</tag>
   <tag count="2091">nikon</tag>
   <tag count="1541">lucbus</tag>
   <tag count="1539">music</tag>
   <tag count="1479">urban</tag>
   <tag count="1425">lucbussieres</tag>
   <tag count="1419">festival</tag>
   <!-- and so on -->
</tags>
*/
			'parameters' => array(
				'woe_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'place_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'min_upload_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'max_upload_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'min_taken_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'max_taken_date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.places.tagsForPlace',
				),
			),
		),

// 163
		"flickr.prefs.getContentType" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns the default content type preference for the user.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<rsp stat="ok">
<person nsid="12037949754@N01" content_type="1" />
</rsp>
*/
			'parameters' => array(
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.prefs.getContentType',
				),
			),
		),

// 164
		"flickr.prefs.getGeoPerms" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns the default privacy level for geographic information attached to the user\'s photos and whether or not the user has chosen to use geo-related EXIF information to automatically geotag their photos.

Possible values, for viewing geotagged photos, are:

<ul>
<li>0 : <i>No default set</i></li>
<li>1 : Public</li>
<li>2 : Contacts only</li>
<li>3 : Friends and Family only</li>
<li>4 : Friends only</li>
<li>5 : Family only</li>
<li>6 : Private</li>
</ul>

Users can edit this preference at <a href="http://www.flickr.com/account/geo/privacy/">http://www.flickr.com/account/geo/privacy/</a>.
<br /><br />
Possible values for whether or not geo-related EXIF information will be used to geotag a photo are:

<ul>
<li>0: Geo-related EXIF information will be ignored</li>
<li>1: Geo-related EXIF information will be used to try and geotag photos on upload</li>
</ul>

Users can edit this preference at <a href="http://www.flickr.com/account/geo/exif/?from=privacy">http://www.flickr.com/account/geo/exif/?from=privacy</a>',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<rsp stat="ok">
<person nsid="12037949754@N01" geoperms="1" importgeoexif="0" />
</rsp>
*/
			'parameters' => array(
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.prefs.getGeoPerms',
				),
			),
		),

// 165
		"flickr.prefs.getHidden" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns the default hidden preference for the user.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<rsp stat="ok">
<person nsid="12037949754@N01" hidden="1" />
</rsp>
*/
			'parameters' => array(
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.prefs.getHidden',
				),
			),
		),

// 166
		"flickr.prefs.getPrivacy" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns the default privacy level preference for the user.

Possible values are:
<ul>
<li>1 : Public</li>
<li>2 : Friends only</li>
<li>3 : Family only</li>
<li>4 : Friends and Family</li>
<li>5 : Private</li>
</ul>',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<rsp stat="ok">
<person nsid="12037949754@N01" privacy="1" />
</rsp>
*/
			'parameters' => array(
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.prefs.getPrivacy',
				),
			),
		),

// 167
		"flickr.prefs.getSafetyLevel" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns the default safety level preference for the user.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<rsp stat="ok">
<person nsid="12037949754@N01" safety_level="1" />
</rsp>
*/
			'parameters' => array(
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.prefs.getSafetyLevel',
				),
			),
		),

// 168
		"flickr.push.getSubscriptions" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns a list of the subscriptions for the logged-in user.
<br><br>
<i>(this method is experimental and may change)</i>',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<rsp stat="ok">
  <subscriptions>
    <subscription topic="contacts_photos" callback="http://example.com/contacts_photos_endpoint?user=12345" pending="0" date_create="1309293755" lease_seconds="0" expiry="1309380155" verify_attempts="0" />
    <subscription topic="contacts_faves" callback="http://example.com/contacts_faves_endpoint?user=12345" pending="0" date_create="1309293785" lease_seconds="0" expiry="1309380185" verify_attempts="0" />
  </subscriptions>
</rsp>
*/
			'parameters' => array(
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.push.getSubscriptions',
				),
			),
		),

// 169
		"flickr.push.getTopics" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'All the different flavours of anteater.
<br><br>
<i>(this method is experimental and may change)</i>',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<rsp stat="ok">
  <topics>
    <topic name="contacts_photos" />
    <topic name="contacts_faves" />
  </topics>
</rsp>
*/
			'parameters' => array(
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.push.getTopics',
				),
			),
		),

// 170
		"flickr.push.subscribe" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'In ur pandas, tickling ur unicorn
<br><br>
<i>(this method is experimental and may change)</i>',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'topic'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'callback'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'verify'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'verify_token'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'lease_seconds'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'woe_ids'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'place_ids'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'lat'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'lon'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'radius'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'radius_units'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'accuracy'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'nsids'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'tags'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'machine_tags'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'update_type'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'output_format'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'mailto'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.push.subscribe',
				),
			),
		),

// 171
		"flickr.push.unsubscribe" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Why would you want to do this?
<br><br>
<i>(this method is experimental and may change)</i>',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'topic'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'callback'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'verify'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'verify_token'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.push.unsubscribe',
				),
			),
		),

// 172
		"flickr.reflection.getMethodInfo" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns information for a given flickr API method.',
			"responseClass" => "Intahwebz\\FlickrGuzzle\\DTO\\MethodInfo",
			'parameters' => array(
				'method_name'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.reflection.getMethodInfo',
				),
			),
		),

// 173
		"flickr.reflection.getMethods" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns a list of available flickr API methods.',
			"responseClass" => "Intahwebz\\FlickrGuzzle\\DTO\\MethodList",
			'parameters' => array(
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.reflection.getMethods',
				),
			),
		),

// 174
		"flickr.stats.getCollectionDomains" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get a list of referring domains for a collection',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<domains page="1" perpage="25" pages="1" total="3">
	<domain name="images.search.yahoo.com" views="127" />
	<domain name="flickr.com" views="122" />
	<domain name="images.google.com" views="70" />
</domains>

*/
			'parameters' => array(
				'date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'collection_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.stats.getCollectionDomains',
				),
			),
		),

// 175
		"flickr.stats.getCollectionReferrers" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get a list of referrers from a given domain to a collection',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<domain page="1" perpage="25" pages="1" total="3" name="flickr.com">
	<referrer url="http://flickr.com/" views="11"/>
	<referrer url="http://flickr.com/photos/friends/" views="8"/>
	<referrer url="http://flickr.com/search/?q=stats+api" views="2" searchterm="stats api"/>
</domain>

*/
			'parameters' => array(
				'date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'domain'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'collection_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.stats.getCollectionReferrers',
				),
			),
		),

// 176
		"flickr.stats.getCollectionStats" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get the number of views on a collection for a given date.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<stats views="24" />
*/
			'parameters' => array(
				'date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'collection_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.stats.getCollectionStats',
				),
			),
		),

// 177
		"flickr.stats.getCSVFiles" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns a list of URLs for text files containing <i>all</i> your stats data (from November 26th 2007 onwards) for the currently auth\'d user.

<b>Please note, these files will only be available until June 1, 2010 Noon PDT.</b> 
For more information <a href="/help/stats/#1369409">please check out this FAQ</a>, or just <a href="/photos/me/stats/downloads/">go download your files</a>.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<stats> 
   <csvfiles> 
      <csv href="http://farm4.static.flickr.com/3496/stats/72157623902771865_faaa.csv" type="daily" date="2010-04-01" /> 
      <csv href="http://farm4.static.flickr.com/3376/stats/72157624027152370_fbbb.csv" type="monthly" date="2010-04-01" /> 
      <csv href="http://farm5.static.flickr.com/4006/stats/72157623627769689_fccc.csv" type="daily" date="2010-03-01" /> 
      ....
    </csvfiles> 
</stats>
*/
			'parameters' => array(
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.stats.getCSVFiles',
				),
			),
		),

// 178
		"flickr.stats.getPhotoDomains" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get a list of referring domains for a photo',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<domains page="1" perpage="25" pages="1" total="3">
	<domain name="images.search.yahoo.com" views="127" />
	<domain name="flickr.com" views="122" />
	<domain name="images.google.com" views="70" />
</domains>

*/
			'parameters' => array(
				'date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.stats.getPhotoDomains',
				),
			),
		),

// 179
		"flickr.stats.getPhotoReferrers" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get a list of referrers from a given domain to a photo',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<domain page="1" perpage="25" pages="1" total="3" name="flickr.com">
	<referrer url="http://flickr.com/" views="11"/>
	<referrer url="http://flickr.com/photos/friends/" views="8"/>
	<referrer url="http://flickr.com/search/?q=stats+api" views="2" searchterm="stats api"/>
</domain>
*/
			'parameters' => array(
				'date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'domain'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.stats.getPhotoReferrers',
				),
			),
		),

// 180
		"flickr.stats.getPhotosetDomains" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get a list of referring domains for a photoset',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<domains page="1" perpage="25" pages="1" total="3">
	<domain name="images.search.yahoo.com" views="127" />
	<domain name="flickr.com" views="122" />
	<domain name="images.google.com" views="70" />
</domains>

*/
			'parameters' => array(
				'date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'photoset_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.stats.getPhotosetDomains',
				),
			),
		),

// 181
		"flickr.stats.getPhotosetReferrers" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get a list of referrers from a given domain to a photoset',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<domain page="1" perpage="25" pages="1" total="3" name="flickr.com">
	<referrer url="http://flickr.com/" views="11"/>
	<referrer url="http://flickr.com/photos/friends/" views="8"/>
	<referrer url="http://flickr.com/search/?q=stats+api" views="2" searchterm="stats api"/>
</domain>
*/
			'parameters' => array(
				'date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'domain'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'photoset_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.stats.getPhotosetReferrers',
				),
			),
		),

// 182
		"flickr.stats.getPhotosetStats" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get the number of views on a photoset for a given date.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<stats views="24" comments="1" />
*/
			'parameters' => array(
				'date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'photoset_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.stats.getPhotosetStats',
				),
			),
		),

// 183
		"flickr.stats.getPhotoStats" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get the number of views, comments and favorites on a photo for a given date.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<stats views="24" comments="4" favorites="1"/>
*/
			'parameters' => array(
				'date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.stats.getPhotoStats',
				),
			),
		),

// 184
		"flickr.stats.getPhotostreamDomains" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get a list of referring domains for a photostream',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<domains page="1" perpage="25" pages="1" total="3">
	<domain name="images.search.yahoo.com" views="127" />
	<domain name="flickr.com" views="122" />
	<domain name="images.google.com" views="70" />
</domains>

*/
			'parameters' => array(
				'date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.stats.getPhotostreamDomains',
				),
			),
		),

// 185
		"flickr.stats.getPhotostreamReferrers" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get a list of referrers from a given domain to a user\'s photostream',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<domain page="1" perpage="25" pages="1" total="3" name="flickr.com">
	<referrer url="http://flickr.com/" views="11"/>
	<referrer url="http://flickr.com/photos/friends/" views="8"/>
	<referrer url="http://flickr.com/search/?q=stats+api" views="2" searchterm="stats api"/>
</domain>
*/
			'parameters' => array(
				'date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'domain'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.stats.getPhotostreamReferrers',
				),
			),
		),

// 186
		"flickr.stats.getPhotostreamStats" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get the number of views on a user\'s photostream for a given date.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<stats views="24" />
*/
			'parameters' => array(
				'date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.stats.getPhotostreamStats',
				),
			),
		),

// 187
		"flickr.stats.getPopularPhotos" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'List the photos with the most views, comments or favorites',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<photos page="2" pages="89" perpage="10" total="881">
	<photo id="2636" owner="47058503995@N01" 
		secret="a123456" server="2" title="test_04"
		ispublic="1" isfriend="0" isfamily="0">
		<stats views="941" comments="18" favorites="2"/>
	</photo>
	<photo id="2635" owner="47058503995@N01"
		secret="b123456" server="2" title="test_03"
		ispublic="0" isfriend="1" isfamily="1">
		<stats views="141" comments="1" favorites="2"/>
	</photo>
</photos>
*/
			'parameters' => array(
				'date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'sort'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'per_page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'page'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.stats.getPopularPhotos',
				),
			),
		),

// 188
		"flickr.stats.getTotalViews" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get the overall view counts for an account',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<stats>
	<total views="469" />
	<photos views="386" />
	<photostream views="72" />
	<sets views="11" />
	<collections views="0" />
</stats>
*/
			'parameters' => array(
				'date'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.stats.getTotalViews',
				),
			),
		),

// 189
		"flickr.tags.getClusterPhotos" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns the first 24 photos for a given tag cluster',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'tag'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'cluster_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.tags.getClusterPhotos',
				),
			),
		),

// 190
		"flickr.tags.getClusters" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Gives you a list of tag clusters for the given tag.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<clusters source="cows" total="2">
	<cluster total="3">
		<tag>farm</tag>
		<tag>animals</tag>
		<tag>cattle</tag>
	</cluster>
	<cluster total="3">
		<tag>green</tag>
		<tag>landscape</tag>
		<tag>countryside</tag>
	</cluster>
</clusters>
*/
			'parameters' => array(
				'tag'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.tags.getClusters',
				),
			),
		),

// 191
		"flickr.tags.getHotList" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns a list of hot tags for the given period.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<hottags period="day" count="6">
	<tag score="20">northerncalifornia</tag>
	<tag score="18">top20</tag>
	<tag score="15">keychain</tag>
	<tag score="10">zb</tag>
	<tag score="9">selfportraittuesday</tag>
	<tag score="4">jan06</tag>
</hottags>
*/
			'parameters' => array(
				'period'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'count'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.tags.getHotList',
				),
			),
		),

// 192
		"flickr.tags.getListPhoto" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get the tag list for a given photo.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<photo id="2619">
	<tags>
		<tag id="156" author="12037949754@N01"
			authorname="Bees" raw="tag 1">tag1</tag> 
		<tag id="157" author="12037949754@N01"
			authorname="Bees" raw="tag 2">tag2</tag> 
	</tags>
</photo>
*/
			'parameters' => array(
				'photo_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.tags.getListPhoto',
				),
			),
		),

// 193
		"flickr.tags.getListUser" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get the tag list for a given user (or the currently logged in user).',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<who id="12037949754@N01">
	<tags>
		<tag>gull</tag> 
		<tag>tag1</tag> 
		<tag>tag2</tag> 
		<tag>tags</tag> 
		<tag>test</tag> 
	</tags>
</who>
*/
			'parameters' => array(
				'user_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.tags.getListUser',
				),
			),
		),

// 194
		"flickr.tags.getListUserPopular" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get the popular tags for a given user (or the currently logged in user).',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<who id="12037949754@N01">
	<tags>
		<tag count="10">bar</tag> 
		<tag count="11">foo</tag> 
		<tag count="147">gull</tag> 
		<tag count="3">tags</tag> 
		<tag count="3">test</tag> 
	</tags>
</who>
*/
			'parameters' => array(
				'user_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'count'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.tags.getListUserPopular',
				),
			),
		),

// 195
		"flickr.tags.getListUserRaw" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Get the raw versions of a given tag (or all tags) for the currently logged-in user.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<who id="12037949754@N01">
    <tags>
        <tag clean="foo">
            <raw>foo</raw>
            <raw>Foo</raw>
            <raw>f:oo</raw>
        </tag>
    </tags>
</who>
*/
			'parameters' => array(
				'tag'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.tags.getListUserRaw',
				),
			),
		),

// 196
		"flickr.tags.getMostFrequentlyUsed" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns a list of most frequently used tags for a user.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<rsp stat="ok">
<who id="30135021@N05">
	<tags>
		<tag count="1">blah</tag>
		<tag count="5">publicdomain</tag>
	</tags>
</who>
</rsp>
*/
			'parameters' => array(
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.tags.getMostFrequentlyUsed',
				),
			),
		),

// 197
		"flickr.tags.getRelated" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns a list of tags "related" to the given tag, based on clustered usage analysis.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<tags source="london">
	<tag>england</tag>
	<tag>thames</tag>
	<tag>tube</tag>
	<tag>bigben</tag>
	<tag>uk</tag>
</tags>

*/
			'parameters' => array(
				'tag'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.tags.getRelated',
				),
			),
		),

// 198
		"flickr.test.echo" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'A testing method which echo\'s all parameters back in the response.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<method>echo</method>
<foo>bar</foo>
*/
			'parameters' => array(
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.test.echo',
				),
			),
		),

// 199
		"flickr.test.login" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'A testing method which checks if the caller is logged in then returns their username.',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<user id="12037949754@N01">
	<username>Bees</username> 
</user>

*/
			'parameters' => array(
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.test.login',
				),
			),
		),

// 200
		"flickr.test.null" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Null test',
			'needsSigning' => true,
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			'parameters' => array(
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.test.null',
				),
			),
		),

// 201
		"flickr.urls.getGroup" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns the url to a group\'s page.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<group nsid="48508120860@N01" url="http://www.flickr.com/groups/test1/" /> 
*/
			'parameters' => array(
				'group_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.urls.getGroup',
				),
			),
		),

// 202
		"flickr.urls.getUserPhotos" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns the url to a user\'s photos.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<user nsid="12037949754@N01" url="http://www.flickr.com/photos/bees/" />
*/
			'parameters' => array(
				'user_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.urls.getUserPhotos',
				),
			),
		),

// 203
		"flickr.urls.getUserProfile" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns the url to a user\'s profile.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<user nsid="12037949754@N01" url="http://www.flickr.com/people/bees/" />
*/
			'parameters' => array(
				'user_id'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
					'optional' => true,
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.urls.getUserProfile',
				),
			),
		),

// 204
		"flickr.urls.lookupGallery" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns gallery info, by url.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<gallery id="6065-72157617483228192" url="/photos/straup/galleries/72157617483228192" owner="35034348999@N01" 
primary_photo_id="292882708" 
date_create="1241028772" date_update="1270111667" 
count_photos="17" count_videos="0" server="112" farm="1" secret="7f29861bc4">
	<title>Cat Pictures I've Sent To Kevin Collins</title>
	<description />
</gallery>
*/
			'parameters' => array(
				'url'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.urls.lookupGallery',
				),
			),
		),

// 205
		"flickr.urls.lookupGroup" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns a group NSID, given the url to a group\'s page or photo pool.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<group id="34427469792@N01">
	<groupname>FlickrCentral</groupname> 
</group>
*/
			'parameters' => array(
				'url'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.urls.lookupGroup',
				),
			),
		),

// 206
		"flickr.urls.lookupUser" => array(
			'extends' => 'defaultGetOperation',
			'summary' => 'Returns a user NSID, given the url to a user\'s photos or profile.',
			'responseClass' => null, //'Intahwebz\FlickrAPI\DTO\',
			/* Example
<user id="12037949632@N01">
	<username>Stewart</username> 
</user>
*/
			'parameters' => array(
				'url'    => array(
					'location' => 'query',
					'description' => 'todo - describe variable',
				),
				'method'    => array(
					'location' => 'query',
					'description' => 'Which flickr call is being made.',
					'default' => 'flickr.urls.lookupUser',
				),
			),
		),


	),

    "models" => array(
	),
);



?>