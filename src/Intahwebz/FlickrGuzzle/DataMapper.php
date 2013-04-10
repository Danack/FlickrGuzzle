<?php


namespace Intahwebz\FlickrGuzzle;


/**
 * Trait DataMapper
 *
 * Allows objects to be created directly from an array of data, mapping keynames in the array to member
 * variable names.
 *
 * @package Intahwebz\FlickrAPI
 */
trait DataMapper {

	static function getValueFromAlias($data, $dataVariableNameArray, &$notSet){

		if ($dataVariableNameArray == null){
			//Return the original data array
			return $data;
		}

		if(is_array($dataVariableNameArray) == FALSE){
			$dataVariableNameArray = array($dataVariableNameArray);
		}

		$dereferenced = $data;

		$aliasPath = '';

		foreach($dataVariableNameArray as $dataVariableName){
			$aliasPath .= '/'.$dataVariableName;
			if(array_key_exists($dataVariableName, $dereferenced) == FALSE){
				$notSet = TRUE;
				return FALSE;
			}
			$dereferenced = $dereferenced[$dataVariableName];
		}

		return $dereferenced;
	}

	/**
	 * @param $data
	 * @return static
	 * @throws \Exception
	 */
	static function createFromData($data){
		if (property_exists(__CLASS__, 'dataMap') == FALSE){
			throw new \Exception("Class ".__CLASS__." is using DataMapper but has not set DataMap.");
		}

		$instance = new static();

		$count = 0;

		foreach(static::$dataMap as $dataMapElement){

			$classVariableName = $dataMapElement[0];
			$dataVariableNameArray = $dataMapElement[1];
			$className = FALSE;
			$multiple = FALSE;

			if (is_array($dataMapElement) == false) {
				$string = \getVar_DumpOutput(static::$dataMap);
				throw new \Exception("DataMap is meant to be composed of arrays of entries. You've missed some brackets in class ". __CLASS__." : ".$string);
			}

			if(array_key_exists('class', $dataMapElement) == TRUE){
				$className = $dataMapElement['class'];
			}
			if(array_key_exists('multiple', $dataMapElement) == TRUE){
				$multiple = $dataMapElement['multiple'];
			}

			$notFound = FALSE;

			$sourceValue = self::getValueFromAlias($data, $dataVariableNameArray, $notFound);

			if($notFound == TRUE){
				if (array_key_exists('optional', $dataMapElement) == TRUE &&
					$dataMapElement['optional'] == TRUE){
					continue;
				}
//
//				var_dump($data);
//				echo "count is $count <br/>";
//				var_dump(static::$dataMap);

				$alias = $dataVariableNameArray;

				if(is_array($dataVariableNameArray) == TRUE){
					$alias = implode('->', $dataVariableNameArray);
				}

				throw new \Exception("DataMapper cannot find value from [".$alias."] for mapping to actual value");
			}

			if($multiple == TRUE){
				$instance->{$classVariableName} = array();

				foreach($sourceValue as $sourceValueInstance){
					if($className != FALSE){
						$object = $className::createFromData($sourceValueInstance);
						$instance->{$classVariableName}[] = $object;
					}
					else{
						$instance->{$classVariableName}[] = $sourceValueInstance;
					}
				}
			}
			else{
				if($className != FALSE){
					$object = $className::createFromData($sourceValue);
					$instance->{$classVariableName} = $object;
				}
				else{
					$instance->{$classVariableName} = $sourceValue;
				}
			}

			$count++;
		}

		return $instance;
	}


//	static function createArrayFromData($dataArray, $deference = FALSE){
//		$objects = array();
//
//		foreach($dataArray as $data){
//
//			if($deference == TRUE){ //Flickr need an extra deferencing here.
//				$data = $data[0]; //$data['urls'] => array(array('type' => 'foo', '_content' => 'bar'))
//			}
//
//			$objects[] = static::createFromData($data);
//		}
//
//		return $objects;
//	}

	function remap($remap, $index){
		foreach($remap as $map){
			if($this->$map != NULL){
				$this->$map = $this->{$map}[$index];
			}
		}
	}
}