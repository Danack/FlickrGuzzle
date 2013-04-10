

Flickr Guzzle
=============

A Guzzle based Flickr API. 

This is currently just here for reference. Although the code is here and can be made to work for a small set of functions, I need to refactor the namespaces to have the correct project name, 'FlickrGuzzle', so they don't currently autoload.



Functions supported
===================

Oauth request token - http://www.flickr.com/services/oauth/request_token
Oauth access token - http://www.flickr.com/services/oauth/access_token',
Upload file - http://api.flickr.com/services/upload/


All other functions are at the end-point:
http://api.flickr.com/services/rest/

flickr.auth.oauth.checkToken
flickr.people.getPhotos
flickr.photos.addTags
flickr.photos.removeTag
flickr.photos.getUntagged
flickr.people.getPublicPhotos
flickr.photos.getInfo
flickr.cameras.getBrands

flickr.cameras.getBrandModels


Functions not implemented yet
=============================

TODO make a giant list, of 90% of the flickr functions.