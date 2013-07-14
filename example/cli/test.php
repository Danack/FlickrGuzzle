<?php

define('FLICKR_KEY', '12345');
define('FLICKR_SECRET', '12345');

require_once "../../vendor/autoload.php";

use Intahwebz\FlickrGuzzle\FlickrGuzzleClient;
use Intahwebz\FlickrGuzzle\FlickrAPIException;


$flickrGuzzleClient = FlickrGuzzleClient::factory();
$blogServicesList = $flickrGuzzleClient->getCommand("flickr.blogs.getServices")->execute();

var_dump($blogServicesList);

//$this->view->assign('blogServicesList', $blogServicesList);
//$this->view->setTemplate("flickr/blogServicesList");

?>