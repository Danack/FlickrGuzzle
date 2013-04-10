<?php


namespace Intahwebz\FlickrGuzzle\DTO;

use Intahwebz\FlickrGuzzle\DataMapper;

class CameraDetail {

	use DataMapper{
		createFromData as createFromDataAuto;
	}

	static protected $dataMap = array(
		['cameraDetailID', 'id'],
		['name', ['name', '_content']],

		['megaPixels', ['details', 'megapixels'], 'optional' => TRUE ],
		['zoom', ['details','zoom',],  'optional' => TRUE ],
		['lcdScreenSize', ['details','lcd_screen_size',], 'optional' => TRUE ],
		['storageType', ['details','memory_type',], 'optional' => TRUE ],
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
	static function createFromData($data){
		$object = self::createFromDataAuto($data);

		if(array_key_exists('images', $data) == TRUE){
			foreach($data['images'] as $size => $image){
				$object->images[$size] = $image['_content'];
			}
		}

		$remap = array(
			'megaPixels',
			'lcdScreenSize',
			'memoryType',
			'zoom',
			'storageType'
		);

		$object->remap($remap, '_content');

		return $object;
	}
}