<?php


use Intahwebz\FlickrGuzzle\FlickrGuzzleClient;
use Intahwebz\FlickrGuzzle\FlickrAPIException;

use Intahwebz\FlickrGuzzle\DTO\MethodInfo;
use Intahwebz\FlickrGuzzle\DTO\OauthAccessToken;
use Intahwebz\FlickrGuzzle\DTO\PhotoList;

use Intahwebz\Utils\UserUploadedFile;

define('FLICKR_IMAGES_PER_PAGE', 12);

class Flickr{

	var $view;
	var $router;

	public function __construct(){
		$this->view = new View();
		$this->router = new Router();
	}

	function clearSessionVariables(){
		unsetSessionVariable('oauthAccessToken');
		unsetSessionVariable('tokenSecret');
	}

	function	scanPhotosForTags(){
		$this->view->setTemplate("flickr/upload");
	}

	function	prePage($action) {
		$routes = array(
			'Index' => 'index',
			'Photos' => 'photoList',
			'Upload' => 'flickrUpload',
			'Camera Brands' => 'flickrCameraBrands',
			'Method List' => 'flickrMethodList',



			//'Generate method info' => 'flickrMethodListGenerate',
			'Institution List' => 'institutionList',
			'License list' => 'licenseList',
			'API progress' => 'apiProgress',

			'User comments' => 'userComments',
			'User photos' => 'userPhotos',

			'Find user by email' => 'findUserByEmail',
			'Find user by username' => 'findUserByUsername',

			'Find places for tags' => 'findPlacesForTags',
			'Find places for bounding box' => 'findPlacesForBoundingBox',

			'Find place' => 'findPlace',

			'Find top places' => 'findTopPlaces',

			'Lookup gallery by URL' => 'lookupGalleryByURL',
			'Lookup user by URL' => 'lookupUserbyURL',
			'Lookup group by URL' => 'lookupGroupByURL',

			'Get contact list' => 'getContactList',
			'Get contact public list' => 'getContactPublicList',

			'Get contact tagging suggestion' => 'getContactTaggingSuggestion',

			'Get Group URL' => 'getGroup',
			'Get user profile URL' => 'getUserProfile',
			'Get user photos URL' => 'getUserPhotos',
			'Get user tags'		=> 'getUserTags',
			'Get user raw tags'		=> 'getUserRawTags',
			'Get user popular tags'		=> 'getUserPopularTags',
			'Get user most frequent tags'		=> 'getUserMostFrequentTags',

			'Get favourites' => 'getFavouritesList',
			'Get public favourites' => 'getFavouritesPublicList',

			'Blog service list' => 'findBlogServicesList',

			'Get hotlist tags' => 'getHotListTags',

			'Logout'		=> 'logout',
		);

		$authedRoutes = array(
			'Get popular photos' => 'getPopularPhotos',
			'Total views' => 'totalViews',

			'Blog list for user' => 'findBlogListForUser',
			//'Find places for user' => 'findPlacesForUser',
			//'Find places for contacts' => 'findPlacesForContacts',
		);


		$this->view->assign('routes', $routes);
		$this->view->assign('authedRoutes', $authedRoutes);
	}


	/**
	 * This function doesn't work and is probably dumb.
	 *
	 * If you need to post something to a blog, you should be calling the blog's api directly, not
	 * calling it through Flickr.
	 *
	 * @param $photoID
	 */
	function blogPost($photoID) {
		$params = array(
			//blog_id (Optional)
			'title' => '',
			'photo_id' => $photoID,
			'service' => 'Twitter',
			'description' => '',
			'blog_password' => '12345'
		);

		$oauthAccessToken = getSessionVariable('oauthAccessToken', FALSE);
		$flickrGuzzleClient = FlickrGuzzleClient::factory($oauthAccessToken);

		$command = $flickrGuzzleClient->getCommand("flickr.blogs.postPhoto", $params);

		$blogResult = $command->execute();

		$data = $command->getRequest()->getResponse()->getBody(TRUE);

		var_dump($data);

		$this->view->addStatusMessage("Twitter post should be posted.");
		$this->photo($photoID);
	}

	function findBlogServicesList() {
		$flickrGuzzleClient = FlickrGuzzleClient::factory();
		$blogServicesList = $flickrGuzzleClient->getCommand("flickr.blogs.getServices")->execute();
		$this->view->assign('blogServicesList', $blogServicesList);
		$this->view->setTemplate("flickr/blogServicesList");
	}


	function findBlogListForUser() {
		$oauthAccessToken = getSessionVariable('oauthAccessToken', FALSE);
		$flickrGuzzleClient = FlickrGuzzleClient::factory($oauthAccessToken);
		$blogList = $flickrGuzzleClient->getCommand("flickr.blogs.getList")->execute();
		$this->view->assign('blogList', $blogList);
		$this->view->setTemplate("flickr/blogList");
	}


	function findPlace() {
		$params = array(
			'query' => 'London'
		);

		$flickrGuzzleClient = FlickrGuzzleClient::factory();
		$placeList = $flickrGuzzleClient->getCommand("flickr.places.find", $params)->execute();
		$this->view->assign('placeList', $placeList);
		$this->view->setTemplate("flickr/placeList");
	}



	function getContactList() {
		$oauthAccessToken = getSessionVariable('oauthAccessToken', FALSE);
		$flickrGuzzleClient = FlickrGuzzleClient::factory($oauthAccessToken);
		$contactList = $flickrGuzzleClient->getCommand("flickr.contacts.getList")->execute();
		$this->view->assign('contactList', $contactList);
		$this->view->setTemplate("flickr/contactList");
	}

	function getContactPublicList() {
		$params = array(
			'user_id' => '46085186@N02'
		);

		$flickrGuzzleClient = FlickrGuzzleClient::factory();
		$contactList = $flickrGuzzleClient->getCommand("flickr.contacts.getPublicList", $params)->execute();
		$this->view->assign('contactList', $contactList);
		$this->view->setTemplate("flickr/contactList");
	}



	function getContactTaggingSuggestion() {
		$oauthAccessToken = getSessionVariable('oauthAccessToken', FALSE);
		$flickrGuzzleClient = FlickrGuzzleClient::factory($oauthAccessToken);
		$contactList = $flickrGuzzleClient->getCommand("flickr.contacts.getTaggingSuggestions")->execute();
		$this->view->assign('contactList', $contactList);
		$this->view->setTemplate("flickr/contactList");
	}

	function findPlacesForUser($woeID) {
		$params = array(
			'woe_id' => $woeID,
			'place_type_id' => FlickrGuzzleClient::PLACE_TYPE_NEIGHBOURHOOD,
		);

		$oauthAccessToken = getSessionVariable('oauthAccessToken', FALSE);
		$flickrGuzzleClient = FlickrGuzzleClient::factory($oauthAccessToken);
		$placeList = $flickrGuzzleClient->getCommand("flickr.places.placesForUser", $params)->execute();
		$this->view->assign('placeList', $placeList);
		$this->view->setTemplate("flickr/placeList");
	}




	function findPlacesForTags() {
		$params = array(
			'place_type_id' => FlickrGuzzleClient::PLACE_TYPE_REGION,
			'woe_id' => 44418, //London, England
			'tags' => 'lorikeet'
		);

		$oauthAccessToken = getSessionVariable('oauthAccessToken', FALSE);
		$flickrGuzzleClient = FlickrGuzzleClient::factory($oauthAccessToken);
		$placeList = $flickrGuzzleClient->getCommand("flickr.places.placesForTags", $params)->execute();
		$this->view->assign('placeList', $placeList);
		$this->view->setTemplate("flickr/placeList");
	}


	function findPlacesForContacts($woeID) {
		$params = array(
			'woe_id' => $woeID,
			'threshold' => 5, //Minimum number photos - will promote to higher 'woeID' to get enough photos
			'place_type_id' => FlickrGuzzleClient::PLACE_TYPE_NEIGHBOURHOOD,
		);

		$oauthAccessToken = getSessionVariable('oauthAccessToken', FALSE);
		$flickrGuzzleClient = FlickrGuzzleClient::factory($oauthAccessToken);
		$placeList = $flickrGuzzleClient->getCommand("flickr.places.placesForContacts", $params)->execute();
		$this->view->assign('placeList', $placeList);
		$this->view->setTemplate("flickr/placeList");
	}



	function findTopPlaces() {

		$params = array(
			'place_type_id' => FlickrGuzzleClient::PLACE_TYPE_REGION,
		);

		$flickrGuzzleClient = FlickrGuzzleClient::factory();
		$placeList = $flickrGuzzleClient->getCommand("flickr.places.getTopPlacesList", $params)->execute();
		$this->view->assign('placeList', $placeList);
		$this->view->setTemplate("flickr/placeList");
	}


	function findPlacesForBoundingBox() {
		$params = array(
			'bbox' => '40.913,-82.66,40.915,-82.64'
		);

		$flickrGuzzleClient = FlickrGuzzleClient::factory();
		$placeList = $flickrGuzzleClient->getCommand("flickr.places.placesForBoundingBox", $params)->execute();
		$this->view->assign('placeList', $placeList);
		$this->view->setTemplate("flickr/placeList");
	}

	function findPlacesWithPhotosPublic($woeID) {
		$params = array(
			'woe_id' => $woeID
		);

		$flickrGuzzleClient = FlickrGuzzleClient::factory();
		$placeList = $flickrGuzzleClient->getCommand("flickr.places.getChildrenWithPhotosPublic", $params)->execute();
		$this->view->assign('placeList', $placeList);
		$this->view->setTemplate("flickr/placeList");
	}



	function getFavouritesList() {
		$oauthAccessToken = getSessionVariable('oauthAccessToken', FALSE);
		$flickrGuzzleClient = FlickrGuzzleClient::factory($oauthAccessToken);

		$photoList = $flickrGuzzleClient->getCommand('flickr.favorites.getList')->execute();
		$this->view->assign('photoList', $photoList);
		$this->view->setTemplate("flickr/photoList");
	}

	function getFavouritesPublicList() {
		$flickrGuzzleClient = FlickrGuzzleClient::factory();

		$params = array(
			'user_id' => '46085186@N02',
		);

		$photoList = $flickrGuzzleClient->getCommand('flickr.favorites.getPublicList', $params)->execute();
		$this->view->assign('photoList', $photoList);
		$this->view->setTemplate("flickr/photoList");
	}

	function getPopularPhotos() {
		$oauthAccessToken = getSessionVariable('oauthAccessToken', FALSE);
		$flickrGuzzleClient = FlickrGuzzleClient::factory($oauthAccessToken);
		$photoList = $flickrGuzzleClient->getCommand('flickr.stats.getPopularPhotos')->execute();
		$this->view->assign('photoList', $photoList);
		$this->view->setTemplate("flickr/photoList");
	}


	function totalViews() {
		$oauthAccessToken = getSessionVariable('oauthAccessToken', FALSE);
		$flickrGuzzleClient = FlickrGuzzleClient::factory($oauthAccessToken);
		$accountStat = $flickrGuzzleClient->getCommand("flickr.stats.getTotalViews")->execute();
		$this->view->assign('accountStat', $accountStat);
		$this->view->setTemplate("flickr/accountStat");
	}


	function findUserByUsername() {

		$params = array(
			'username' => 'Danack',
		);

		$flickrGuzzleClient = FlickrGuzzleClient::factory();
		$lookupUser = $flickrGuzzleClient->getCommand('flickr.people.findByUsername', $params)->execute();
		$this->view->assign('lookupUser', $lookupUser);
		$this->view->setTemplate("flickr/lookupUser");
	}

	function findUserByEmail() {
		$params = array(
			'find_email' => 'Danack@basereality.com',
		);

		$flickrGuzzleClient = FlickrGuzzleClient::factory();
		$lookupUser = $flickrGuzzleClient->getCommand('flickr.people.findByEmail', $params)->execute();
		$this->view->assign('lookupUser', $lookupUser);
		$this->view->setTemplate("flickr/lookupUser");
	}


	function	userComments(){
		$oauthAccessToken = getSessionVariable('oauthAccessToken', FALSE);
		$flickrGuzzleClient = FlickrGuzzleClient::factory($oauthAccessToken);
//		$activityInfo = $flickrGuzzleClient->getCommandAndExecute('flickr.activity.userComments');
		//$activityInfo = $flickrGuzzleClient->getCommand('flickr.activity.userComments')->execute();

		//This is an example of PHPStorms return type hinting.
		$activityInfo = FlickrGuzzleClient::factoryWithCommand('flickr.activity.userComments', $oauthAccessToken);

		//If you're using PHPStorm - the arrow below will show autocomplete suggestions for
		//the ActivityInfo object as PHPstorm knows the variable is of that type.
		//$activityInfo->

		$this->view->assign('activityInfo', $activityInfo);
		$this->view->setTemplate("flickr/activityInfo");
	}


	function	userPhotos(){
		$oauthAccessToken = getSessionVariable('oauthAccessToken', FALSE);
		$flickrGuzzleClient = FlickrGuzzleClient::factory($oauthAccessToken);
		$activityInfo = $flickrGuzzleClient->getCommand('flickr.activity.userPhotos')->execute();
		$this->view->assign('activityInfo', $activityInfo);
		$this->view->setTemplate("flickr/activityInfo");
	}




	function	institutionList(){
		$flickrGuzzleClient = FlickrGuzzleClient::factory();
		$institutionList = $flickrGuzzleClient->getCommand('flickr.commons.getInstitutions')->execute();
		$this->view->assign('institutionList', $institutionList);
		$this->view->setTemplate("flickr/institutionList");
	}


	function	licenseList(){
		$flickrGuzzleClient = FlickrGuzzleClient::factory();
		$licenseList = $flickrGuzzleClient->getCommand('flickr.photos.licenses.getInfo')->execute();
		$this->view->assign('licenseList', $licenseList);
		$this->view->setTemplate("flickr/licenseList");
	}




	function	flickrMethodList(){
		$flickrGuzzleClient = FlickrGuzzleClient::factory();
		$methodList = $flickrGuzzleClient->getCommand('flickr.reflection.getMethods')->execute();
		$this->view->assign('methodList', $methodList);
		$this->view->setTemplate("flickr/methodList");
	}

	function methodInfo($method){
		$flickrGuzzleClient = FlickrGuzzleClient::factory();

		$params = array(
			'method_name' => $method
		);
		$methodInfo = $flickrGuzzleClient->getCommand('flickr.reflection.getMethodInfo', $params)->execute();
		$this->view->assign('methodInfo', $methodInfo);
		$this->view->setTemplate("flickr/methodInfo");
	}


	function	displayBrands(){
		$flickrGuzzleClient = FlickrGuzzleClient::factory();
		$cameraBrandList = $flickrGuzzleClient->getCommand('flickr.cameras.getBrands')->execute();
		$this->view->assign('cameraBrandList', $cameraBrandList);
		$this->view->setTemplate("flickr/brands");
	}

	function	displayBrandModels($cameraBrandID){
		$flickrGuzzleClient = FlickrGuzzleClient::factory();

		$params = array(
			'brand' => $cameraBrandID
		);

		$command = $flickrGuzzleClient->getCommand('flickr.cameras.getBrandModels', $params);

		$cameraDetailList = $command->execute();
		$this->view->assign('cameraDetailList', $cameraDetailList);
		$this->view->setTemplate("flickr/brandModels");
	}

	function	photo($photoID){
		$oauthAccessToken = getSessionVariable('oauthAccessToken', FALSE);
		$flickrGuzzleClient = FlickrGuzzleClient::factory($oauthAccessToken);
		$params = array(
			'photo_id'=> $photoID,
		);

		$command = $flickrGuzzleClient->getCommand('flickr.photos.getInfo', $params);
		$photoInfo = $command->execute();

		$this->view->assign('photoID', $photoID);
		$this->view->assign('photoInfo', $photoInfo);
		$this->view->setTemplate("flickr/photo");
	}

	function flickrAuthResult(){
		$oauthToken = getVariable('oauth_token', FALSE);
		$oauthVerifier = getVariable('oauth_verifier', FALSE);

		$tokenSecret = getSessionVariable('tokenSecret', FALSE);

		if (!$oauthToken ||
			!$oauthVerifier ||
			!$tokenSecret) {
			$this->router->forward('flickr');
		}

		$oauthTokenSession = getSessionVariable('oauthToken');

		if ($oauthToken != $oauthTokenSession) {
			//Miss-match on what we're tring to validated.
			$this->router->forward('flickr');
		}

		$flickrGuzzleClient = FlickrGuzzleClient::factory(
			array(
				'oauth' => TRUE,
				'token' => $oauthToken,
				'token_secret' => $tokenSecret,
			)
		);

		$params = array(
			//'oauth_token' => $oauthToken,
			'oauth_verifier'=> $oauthVerifier,
		);

		$command = $flickrGuzzleClient->getCommand('GetOauthAccessToken', $params);

		$oauthAccessToken  = $command->execute();

		setSessionVariable('oauthAccessToken', $oauthAccessToken);
		$this->router->forward('flickr');
	}


	function photoList($page){

		$authedFlickrGuzzleClient = FALSE;

		$oauthAccessToken = getSessionVariable('oauthAccessToken', FALSE);

		if ($oauthAccessToken != FALSE) {
			$flickrGuzzleClient = FlickrGuzzleClient::factory($oauthAccessToken);

			try{
				$params  = array(
					//'oauth_token' => $oauthAccessToken->oauthToken
				);

				$command = $flickrGuzzleClient->getCommand('flickr.auth.oauth.checkToken', $params);
				$oauthCheck  = $command->execute();

				//Could check values in $oauthCheck but why? We already have oauthAccessToken
				$authedFlickrGuzzleClient = $flickrGuzzleClient;
			}
			catch(FlickrAPIException $fae) {
				echo "Exception caught: ".$fae->getMessage();
				$this->view->setTemplate("flickr/index");
			}
			catch (ClientErrorResponseException $cere) {
				echo "Errror accessing token, clearing session: ".$cere->getMessage();
				$this->clearSessionVariables();
				$this->view->setTemplate("flickr/index");
			}
			catch (ValidationException $ve) {
				echo "You done goofed: ".$ve->getMessage() ;
				$this->clearSessionVariables();
				$this->view->setTemplate("flickr/index");
			}
		}

		if ($authedFlickrGuzzleClient == FALSE) {
			$this->view->setTemplate("flickr/flickrNotAuthed");
		}
		else{
			$params = array(
				'per_page' => FLICKR_IMAGES_PER_PAGE,
				'page' => $page,
				'oauth_token' => $oauthAccessToken->oauthToken,
				'user_id' => $oauthAccessToken->user->nsid,
			);

			$flickrGuzzleClient = FlickrGuzzleClient::factory(
				array(
					'oauth' => TRUE,
					'token_secret' => $oauthAccessToken->oauthTokenSecret,
					'oauth_token' => $oauthAccessToken->oauthToken,
				)
			);

			/** @var $photoList PhotoList */
			$command = $authedFlickrGuzzleClient->getCommand('flickr.people.getPhotos', $params);
			$photoList = $command->execute();
			$this->view->assign('photoList', $photoList);

			$this->view->setTemplate("flickr/photoList");
		}
	}

	function flickrAuthRequest($callbackURL){

		$this->clearSessionVariables();

		$flickrGuzzleClient = FlickrGuzzleClient::factory(array('oauth' => TRUE,));

		$params = array(
			'oauth_callback' => $callbackURL,
		);

		$command = $flickrGuzzleClient->getCommand('GetOauthRequestToken', $params);
		$oauthRequestToken  = $command->execute();

		setSessionVariable('oauthToken', $oauthRequestToken->oauthToken);
		setSessionVariable('tokenSecret', $oauthRequestToken->oauthTokenSecret);

		$flickrURL = "http://www.flickr.com/services/oauth/authorize?oauth_token=".$oauthRequestToken->oauthToken;
		$this->view->assign('flickrURL', $flickrURL);
		$this->view->setTemplate("flickr/flickrAuthRequest");
	}

	function index(){
		$this->view->setTemplate("flickr/index");
	}

	function apiProgress(){
		$apiProgresss = FlickrGuzzleClient::getAPIProgress();
		$this->view->assign('apiProgresss', $apiProgresss);
		$this->view->setTemplate("flickr/apiProgress");
	}

	function replacePhoto($photoID){

		$userUploadedFile = UserUploadedFile::getUserUploadedFile('fileUpload');
		$oauthAccessToken = getSessionVariable('oauthAccessToken', FALSE);
		$flickrGuzzleClient = FlickrGuzzleClient::factory($oauthAccessToken);

		if ($userUploadedFile != FALSE) {

			$params = array(
				'photo' => $userUploadedFile->tmpName,
				'photo_id' => $photoID,
			);

			$command = $flickrGuzzleClient->getCommand('ReplacePhoto', $params);
			$fileUploadResponse = $command->execute();

			$url = "/index.php?function=photo&photoID=".$fileUploadResponse->photoID;
			$message = "<a href='$url'>Photo replaced ".$fileUploadResponse->photoID."</a>";
			$this->view->addStatusMessage($message);
		}

		$this->view->setTemplate("flickr/flickrUpload");
	}


	function	flickrUpload() {

		$userUploadedFile = UserUploadedFile::getUserUploadedFile('fileUpload');

		$title = getVariable('title', FALSE);
		$description = getVariable('description', FALSE);

		if ($userUploadedFile != FALSE) {

			$oauthAccessToken = getSessionVariable('oauthAccessToken', FALSE);
			$flickrGuzzleClient = FlickrGuzzleClient::factory($oauthAccessToken);

			$params = array(
				'photo' => $userUploadedFile->tmpName,
				'title' => $title,
				'description' => $description,
			);

			$command = $flickrGuzzleClient->getCommand('UploadPhoto', $params);

			/** @var $result FileUploadResponse */
			$fileUploadResponse = $command->execute();

			$url = "/index.php?function=photo&photoID=".$fileUploadResponse->photoID;
			$message = "<a href='$url'>Photo uploaded ".$fileUploadResponse->photoID."</a>";
			$this->view->addStatusMessage($message);
		}
		else{
			//echo "Nothing to upload.";
		}

		$this->view->setTemplate("flickr/flickrUpload");
	}

	function rotate($photoID, $degrees) {
		$oauthAccessToken = getSessionVariable('oauthAccessToken', FALSE);
		$flickrGuzzleClient = FlickrGuzzleClient::factory($oauthAccessToken);

		$params = array(
			'photo_id'	=> $photoID,
			'degrees'	=> $degrees,
		);

		$command = $flickrGuzzleClient->getCommand('flickr.photos.transform.rotate', $params);
		$photoTransformInfo = $command->execute();

		$this->view->addStatusMessage("Photo should have been rotated by  ".$degrees.".");
		$this->photo($photoID);
	}


	function getPhotoTags($photoID) {
		$oauthAccessToken = getSessionVariable('oauthAccessToken', FALSE);
		$flickrGuzzleClient = FlickrGuzzleClient::factory($oauthAccessToken);

		$params = array(
			'photo_id'	=> $photoID,
		);

		$command = $flickrGuzzleClient->getCommand('flickr.tags.getListPhoto', $params);
		$tagList = $command->execute();

		$this->view->assign('tagList', $tagList);

		$this->photo($photoID);
	}

	function addToFavourites($photoID) {
		$oauthAccessToken = getSessionVariable('oauthAccessToken', FALSE);
		$flickrGuzzleClient = FlickrGuzzleClient::factory($oauthAccessToken);

		$params = array(
			'photo_id'	=> $photoID,
		);

		$command = $flickrGuzzleClient->getCommand('flickr.favorites.add', $params);
		$photoTransformInfo = $command->execute();
		$this->view->addStatusMessage("Photo should now be a favourite.");
		$this->photo($photoID);
	}


	function removeFromFavourites($photoID) {
		$oauthAccessToken = getSessionVariable('oauthAccessToken', FALSE);
		$flickrGuzzleClient = FlickrGuzzleClient::factory($oauthAccessToken);

		$params = array(
			'photo_id'	=> $photoID,
		);

		$command = $flickrGuzzleClient->getCommand('flickr.favorites.remove', $params);
		$photoTransformInfo = $command->execute();
		$this->view->addStatusMessage("Photo should no longer be a favourite.");
		$this->photo($photoID);
	}


	function addNote($photoID, $noteText) {
		$oauthAccessToken = getSessionVariable('oauthAccessToken', FALSE);
		$flickrGuzzleClient = FlickrGuzzleClient::factory($oauthAccessToken);

		$params = array(
			'photo_id'	=> $photoID,
			'note_text'	=> $noteText,

			'note_x' => 50,
			'note_y' => 150,
			'note_w' => 150,
			'note_h' => 150,
		);

		$command = $flickrGuzzleClient->getCommand('flickr.photos.notes.add', $params);
		$photoTransformInfo = $command->execute();

		$this->view->addStatusMessage("Note should have been added to photo.");
		$this->photo($photoID);
	}


	function deleteNote($photoID, $noteID) {
		$oauthAccessToken = getSessionVariable('oauthAccessToken', FALSE);
		$flickrGuzzleClient = FlickrGuzzleClient::factory($oauthAccessToken);

		$params = array(
			'note_id'	=> $noteID,
		);

		$command = $flickrGuzzleClient->getCommand('flickr.photos.notes.delete', $params);
		$command->execute();

		$this->view->addStatusMessage("Note should have been deleted from photo.");
		$this->photo($photoID);
	}

	function	lookupGalleryByURL(){
		$params = array(
			'url' => 'http://www.flickr.com/photos/sfhipchick/galleries/72157629326823342/'
		);

		$flickrGuzzleClient = FlickrGuzzleClient::factory();
		$lookupGallery = $flickrGuzzleClient->getCommand('flickr.urls.lookupGallery', $params)->execute();
		$this->view->assign('lookupGallery', $lookupGallery);
		$this->view->setTemplate("flickr/lookupGallery");
	}

	function	lookupUserbyURL(){
		$params = array(
			'url' => 'http://www.flickr.com/photos/danack/'
		);

		$flickrGuzzleClient = FlickrGuzzleClient::factory();
		$lookupUser = $flickrGuzzleClient->getCommand('flickr.urls.lookupUser', $params)->execute();
		$this->view->assign('lookupUser', $lookupUser);
		$this->view->setTemplate("flickr/lookupUser");
	}

	function	lookupGroupByURL(){
		$params = array(
			'url' => 'http://www.flickr.com/groups/rainbowlorikeets/'
		);

		$flickrGuzzleClient = FlickrGuzzleClient::factory();
		$lookupGroup = $flickrGuzzleClient->getCommand('flickr.urls.lookupGroup', $params)->execute();
		$this->view->assign('lookupGroup', $lookupGroup);
		$this->view->setTemplate("flickr/lookupGroup");
	}

	function getHotListTags() {
		$oauthAccessToken = getSessionVariable('oauthAccessToken', FALSE);
		$flickrGuzzleClient = FlickrGuzzleClient::factory($oauthAccessToken);

		$params = array(
			//'user_id'
		);
		$command = $flickrGuzzleClient->getCommand('flickr.tags.getHotList', $params);
		$tagList = $command->execute();

		$this->view->assign('tagList', $tagList);
		$this->view->setTemplate("flickr/tagList");
	}



	function getUserMostFrequentTags() {
		$oauthAccessToken = getSessionVariable('oauthAccessToken', FALSE);
		$flickrGuzzleClient = FlickrGuzzleClient::factory($oauthAccessToken);

		$params = array(
			//'user_id'
		);
		$command = $flickrGuzzleClient->getCommand('flickr.tags.getMostFrequentlyUsed', $params);
		$tagList = $command->execute();

		$this->view->assign('tagList', $tagList);
		$this->view->setTemplate("flickr/tagList");
	}

	function getUserPopularTags() {
		$oauthAccessToken = getSessionVariable('oauthAccessToken', FALSE);
		$flickrGuzzleClient = FlickrGuzzleClient::factory($oauthAccessToken);

		$params = array(
			//'user_id'
		);
		$command = $flickrGuzzleClient->getCommand('flickr.tags.getListUserPopular', $params);
		$tagList = $command->execute();

		$this->view->assign('tagList', $tagList);
		$this->view->setTemplate("flickr/tagList");
	}



	function getRelatedTags($tag) {
		$oauthAccessToken = getSessionVariable('oauthAccessToken', FALSE);
		$flickrGuzzleClient = FlickrGuzzleClient::factory($oauthAccessToken);

		$params = array(
			'tag' => $tag
		);
		$command = $flickrGuzzleClient->getCommand('flickr.tags.getRelated', $params);
		$tagList = $command->execute();

		$this->view->assign('tagList', $tagList);
		$this->view->setTemplate("flickr/tagList");
	}


	function getUserRawTags() {
		$oauthAccessToken = getSessionVariable('oauthAccessToken', FALSE);
		$flickrGuzzleClient = FlickrGuzzleClient::factory($oauthAccessToken);

		$params = array(
			//'user_id'
		);
		$command = $flickrGuzzleClient->getCommand('flickr.tags.getListUserRaw', $params);
		$tagList = $command->execute();

		$this->view->assign('tagList', $tagList);
		$this->view->setTemplate("flickr/tagList");
	}


	function getUserTags() {
		$oauthAccessToken = getSessionVariable('oauthAccessToken', FALSE);
		$flickrGuzzleClient = FlickrGuzzleClient::factory($oauthAccessToken);

		$params = array(
			//'user_id'
		);
		$command = $flickrGuzzleClient->getCommand('flickr.tags.getListUser', $params);
		$tagList = $command->execute();

		$this->view->assign('tagList', $tagList);
		$this->view->setTemplate("flickr/tagList");
	}

	function	getUserProfile(){
		$params = array(
			'user_id' => '46085186@N02'
		);
		$flickrGuzzleClient = FlickrGuzzleClient::factory();
		$urlInfo = $flickrGuzzleClient->getCommand('flickr.urls.getUserProfile', $params)->execute();
		$this->view->addStatusMessage("User profile is at:");
		$this->view->assign('urlInfo', $urlInfo);
		$this->view->setTemplate("flickr/urlInfo");
	}

	function	getUserPhotos(){
		$params = array(
			'user_id' => '46085186@N02'
		);

		$flickrGuzzleClient = FlickrGuzzleClient::factory();
		$urlInfo = $flickrGuzzleClient->getCommand('flickr.urls.getUserPhotos', $params)->execute();
		$this->view->addStatusMessage("User photos are at:");
		$this->view->assign('urlInfo', $urlInfo);
		$this->view->setTemplate("flickr/urlInfo");
	}

	function	getGroup(){
		$params = array(
			'group_id' => '64975644@N00'//Group name Rainbow Lorikeets
		);

		$flickrGuzzleClient = FlickrGuzzleClient::factory();
		$urlInfo = $flickrGuzzleClient->getCommand('flickr.urls.getGroup', $params)->execute();

		$this->view->addStatusMessage("Group info is:");

		$this->view->assign('urlInfo', $urlInfo);
		$this->view->setTemplate("flickr/urlInfo");
	}




}


?>