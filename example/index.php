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


$routes = array(
	'Index' => 'flickr',
	'Upload' => 'flickrUpload',
	'Camera Brands' => 'flickrCameraBrands',
	'Method List' => 'flickrMethodList',
);

session_name(SESSION_NAME);
session_start();

pageStart();

try{
	$flickr = new Flickr();

	$flickr->prePage('');

	$function = getVariable('function', 'display');

	switch($function){
		case 'display':{
			$page = getVariable('page', 1);
			$flickr->display($page);
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
			echo "Unknown function [".$function."]<br/>";
			break;
		}
	}

	$flickr->view->render();
}
catch(\Exception $e){
	echo "Exception caught: ".$e->getMessage();
}

pageEnd();



?>