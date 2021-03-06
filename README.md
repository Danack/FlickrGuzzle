Flickr Guzzle
=============

A Guzzle based Flickr API.

Example
=======

A comprehensive set of examples is included as a standalone web application. To get this running:

1 Install the requirements via composer (php composer.phar install --dev)

2 Point a web server at the directory FlickrGuzzle/example with the directory index set to index.php

3 Copy FlickrGuzzle/example/configSample.php to FlickrGuzzle/example/config.php and put your Flickr key and secret in there.

You should now be able to point your browser to the


Functions not implemented yet
=============================

The service.php file has been auto-generated using the reflection methods 'flickr.reflection.getMethodInfo' and 'flickr.reflection.getMethods'.

Although all the functions are listed, only the ones that have something other than 'null' for the response class will actually work.


TODO
====

* Create and set the response classes for the 90% of functions that don't have them yet.
* Create tests.
* Start tagging versions.
* Figure out what to do about every flickr function having it's own set of error codes :(
* Implement the replace function at http://api.flickr.com/services/replace/
* Decide whether to implement the flickr.push.* functions.
* Figure out how to return array of objects without having (almost) useless 'List' container objects.


Function end point
==================

Please note that the three functions:

Oauth request token - http://www.flickr.com/services/oauth/request_token
Oauth access token - http://www.flickr.com/services/oauth/access_token',
Upload file - http://api.flickr.com/services/upload/

Have their own end-point, which is different from the rest of the API. Also these functions do not return JSON data ever. It's either string-pairs or XML.


Non-implemented functions
=========================

The following functions are not implemented and never will be.

* Deprecated auth functions
	* flickr.auth.checkToken
	* flickr.auth.getFrob
	* flickr.auth.getFullToken
	* flickr.auth.getToken

* Test functions
	* flickr.test.echo
	* flickr.test.login
	* flickr.test.null





