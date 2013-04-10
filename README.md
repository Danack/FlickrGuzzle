

Flickr Guzzle
=============

A Guzzle based Flickr API. 

This is currently just here for reference. Although the code is here and can be made to work for a small set of functions, I need to refactor the namespaces to have the correct project name, 'FlickrGuzzle', so they don't currently autoload.

The deprecated functions (e.g. flickr.auth.*) are not implemented.

WARNING
=======

This currently uses a custom version of Guzzle with a slightly different way of creating the responseObjects. I hope to get this new feature implemented in Guzzle in a few days (when it's polished up) to avoid requiring the custom library.


Functions not implemented yet
=============================

The service.php file has been auto-generated using the reflection methods 'flickr.reflection.getMethodInfo' and 'flickr.reflection.getMethods'.

Although all the functions are listed, only the ones that have something other than 'null' for the response class will actually work.


TODO
====

* Add some example code.
* Create and set the response classes for the 90% of functions that don't have them yet.
* Create tests.
* Start tagging versions.



Function end point
==================

Please note that the three functions:

Oauth request token - http://www.flickr.com/services/oauth/request_token
Oauth access token - http://www.flickr.com/services/oauth/access_token',
Upload file - http://api.flickr.com/services/upload/

Have their own end-point, which is different from the rest of the API. Also these functions do not return JSON data ever. It's either string-pairs or XML.








