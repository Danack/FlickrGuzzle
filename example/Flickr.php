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




			'Lookup gallery by URL' => 'lookupGalleryByURL',
			'Lookup user by URL' => 'lookupUserbyURL',
			'Lookup group by URL' => 'lookupGroupByURL',

			'Get Group URL' => 'getGroup',
			'Get user profile URL' => 'getUserProfile',
			'Get user photos URL' => 'getUserPhotos',

			'Get user tags'		=> 'getUserTags',
			'Get user raw tags'		=> 'getUserRawTags',

			'Get user popular tags'		=> 'getUserPopularTags',

			'Get user most frequent tags'		=> 'getUserMostFrequentTags',

			'Get hotlist tags' => 'getHotListTags',

			'Logout'		=> 'logout',
		);

		$this->view->assign('routes', $routes);
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
		$oauthAccessToken = getSessionVariable('oauthAccessToken', false);
		$flickrGuzzleClient = FlickrGuzzleClient::factory($oauthAccessToken);
		$activityInfo = $flickrGuzzleClient->getCommandAndExecute('flickr.activity.userComments');
//		$activityInfo = FlickrGuzzleClient::factoryWithCommand('flickr.activity.userComments', $oauthAccessToken);
		//$activityInfo = $flickrGuzzleClient->getCommand('flickr.activity.userComments')->execute();
		$this->view->assign('activityInfo', $activityInfo);
		$this->view->setTemplate("flickr/activityInfo");
	}


	function	userPhotos(){
		$oauthAccessToken = getSessionVariable('oauthAccessToken', false);
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

	//flickrMethodList


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



	function	upload(){
		$userUploadedFile = UserUploadedFile::getUserUploadedFile('fileUpload');

		$title = getVariable('title', false);
		$description = getVariable('description', false);

		if ($userUploadedFile != false) {
			//echo "Hey there is a file to upload.";

			$oauthAccessToken = getSessionVariable('oauthAccessToken', false);
			$flickrGuzzleClient = FlickrGuzzleClient::factory($oauthAccessToken);

			$params = array(
				'photo' => $userUploadedFile->tmpName,
				'title' => $title,
				'description' => $description,
			);

			$command = $flickrGuzzleClient->getCommand('UploadPhoto', $params);

			/** @var $result FileUploadResponse */
			$fileUploadResponse = $command->execute();

			$this->view->addStatusMessage("Photo uploaded ".$fileUploadResponse->photoID);
		}
		else{
			//echo "Nothing to upload.";
		}

		$this->view->setTemplate("flickr/upload");
	}


	function	photo($photoID){
		$oauthAccessToken = getSessionVariable('oauthAccessToken', false);
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
		$oauthToken = getVariable('oauth_token', false);
		$oauthVerifier = getVariable('oauth_verifier', false);

		$tokenSecret = getSessionVariable('tokenSecret', false);

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
				'oauth' => true,
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

		$authedFlickrGuzzleClient = false;

		$oauthAccessToken = getSessionVariable('oauthAccessToken', false);

		if ($oauthAccessToken != false) {
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

		if ($authedFlickrGuzzleClient == false) {
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
					'oauth' => true,
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

		$flickrGuzzleClient = FlickrGuzzleClient::factory(
			array('oauth' => true)
		);

		$params = array(
			'oauth_callback' => $callbackURL, //$this->router->generateURLForRoute('flickrAuthResult', array(), true)
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

	function	flickrUpload() {

		$userUploadedFile = UserUploadedFile::getUserUploadedFile('fileUpload');

		$title = getVariable('title', false);
		$description = getVariable('description', false);

		if ($userUploadedFile != false) {
			//echo "Hey there is a file to upload.";

			$oauthAccessToken = getSessionVariable('oauthAccessToken', false);
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
		$oauthAccessToken = getSessionVariable('oauthAccessToken', false);
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
		$oauthAccessToken = getSessionVariable('oauthAccessToken', false);
		$flickrGuzzleClient = FlickrGuzzleClient::factory($oauthAccessToken);

		$params = array(
			'photo_id'	=> $photoID,
		);

		$command = $flickrGuzzleClient->getCommand('flickr.tags.getListPhoto', $params);
		$tagList = $command->execute();

		$this->view->assign('tagList', $tagList);

		$this->photo($photoID);
	}



	function addNote($photoID, $noteText) {
		$oauthAccessToken = getSessionVariable('oauthAccessToken', false);
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
		$oauthAccessToken = getSessionVariable('oauthAccessToken', false);
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
		$oauthAccessToken = getSessionVariable('oauthAccessToken', false);
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
		$oauthAccessToken = getSessionVariable('oauthAccessToken', false);
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
		$oauthAccessToken = getSessionVariable('oauthAccessToken', false);
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
		$oauthAccessToken = getSessionVariable('oauthAccessToken', false);
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
		$oauthAccessToken = getSessionVariable('oauthAccessToken', false);
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
		$oauthAccessToken = getSessionVariable('oauthAccessToken', false);
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