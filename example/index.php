<?php

require_once "../vendor/autoload.php";

if (file_exists("config.php") == false) {
	echo ("You must copy configSample.php to config.php and put your credentials in it.");
	exit(0);
}

require_once "config.php";

require_once "pageFunctions.php";
require_once "webFunctions.php";

require_once "Router.php";
require_once "View.php";
require_once "Flickr.php";


session_name(SESSION_NAME);
session_start();

pageStart();

try{
	$flickr = new Flickr();

	$flickr->prePage('');

	$function = getVariable('function', 'index');

	switch($function){

		case 'logout': {
			$flickr->clearSessionVariables();
			$flickr->index();
			break;
		}

		case 'index':{
			$flickr->index();
			break;
		}

		case 'photo' :{
			$photoID = getVariable('photoID', false);
			if ($photoID) {
				$flickr->photo($photoID);
			}
			else{
				$flickr->index();
			}
			break;
		}

		case 'photoRotate': {
			$photoID = getVariable('photoID', false);
			$degrees = getVariable('degrees', false);
			$flickr->rotate($photoID, $degrees);
			break;
		}

		case 'getPhotoTags': {
			$photoID = getVariable('photoID', false);
			$flickr->getPhotoTags($photoID);
			break;
		}

		case 'getRelatedTags': {
			$tagText = getVariable('tagText', false);
			$flickr->getRelatedTags($tagText);
			break;
		}

		case 'noteAdd': {
			$photoID = getVariable('photoID', false);
			$noteText = getVariable('noteText', false);
			$flickr->addNote($photoID, $noteText);
			break;
		}

		case 'deleteNote': {
			$photoID = getVariable('photoID', false);
			$noteID = getVariable('noteID', false);
			$flickr->deleteNote($photoID, $noteID);
			break;
		}

		case 'apiProgress': {
			$flickr->apiProgress();
			break;
		}

		case 'institutionList': {
			$flickr->institutionList();
			break;
		}


		case 'methodInfo': {
			$method = getVariable('method', false);
			$flickr->methodInfo($method);
			break;
		}

		case 'photoList':{
			$page = getVariable('page', 1);
			$flickr->photoList($page);
			break;
		}

		case 'flickrAuthRequest': {

			$callbackURL = sprintf('%s://%s:%d%s',
				(@$_SERVER['HTTPS'] == "on") ? 'https' : 'http',
				$_SERVER['SERVER_NAME'],
				$_SERVER['SERVER_PORT'],
				$_SERVER['SCRIPT_NAME']
			);

			$callbackURL .= "?function=flickrAuthResult";

			$flickr->flickrAuthRequest($callbackURL);
			break;
		}

		case 'flickrAuthResult': {
			$flickr->flickrAuthResult();
			break;
		}

		case 'flickrCameraBrands': {
			$flickr->displayBrands();
			break;
		}

		case 'flickrCameraBrandModels': {
			$cameraBrandID = getVariable('cameraBrandID', false);
			$flickr->displayBrandModels($cameraBrandID);
			break;
		}


		default: {
			if (method_exists ($flickr, $function)) {
				$flickr->{$function}();
				break;
			}
			echo "Unknown function [".$function."]<br/>";
			return;
		}
	}

	$flickr->view->render();
}
catch(\Exception $e){
	echo "Exception caught: ".$e->getMessage();

	$flickr->view->renderFooter();
}

pageEnd();



?>