<?php


class Router {


	function forward($route){

		header("Location: /index.php", 302);
		exit(0);
		//http://www.example.org/index.php
		//$this->router->forward('flickr');
	}

}



?>