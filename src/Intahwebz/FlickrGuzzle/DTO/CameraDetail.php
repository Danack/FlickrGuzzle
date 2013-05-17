<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class CameraDetail {

	use DataMapper{
		createFromJson as createFromJsonAuto;
	}

	static protected $dataMap = array(
		['cameraDetailID', 'id'],
		['name', ['name', '_content']],

		['megaPixels', ['details', 'megapixels', '_content'], 'optional' => TRUE ],
		['zoom', ['details','zoom', '_content'],  'optional' => TRUE ],
		['lcdScreenSize', ['details','lcd_screen_size', '_content'], 'optional' => TRUE ],

		['memoryType', ['details','memory_type', '_content'], 'optional' => TRUE ],
		['storageType', ['details','storage_type', '_content'], 'optional' => TRUE ],
	);

	var $cameraDetailID;
	var $name ;

	var $megaPixels  = NULL;
	var $lcdScreenSize = NULL;
	var $memoryType  = NULL;
	var $zoom = NULL;

	var $storageType = NULL;
	var $images = array();


	/**
	 * @param $data
	 * @return static
	 */
	static function createFromJson($data){
		$object = self::createFromJsonAuto($data);

		if(array_key_exists('images', $data) == TRUE){
			foreach($data['images'] as $size => $image){
				$object->images[$size] = $image['_content'];
			}
		}

//		$remap = array(
//			'megaPixels',
//			'lcdScreenSize',
//			'memoryType',
//			'zoom',
//			'storageType'
//		);
//
//		$object->remap($remap, '_content');

		return $object;
	}
}