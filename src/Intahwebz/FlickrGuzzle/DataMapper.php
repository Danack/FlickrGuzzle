<?php

namespace Intahwebz\FlickrGuzzle;


/**
 * Trait DataMapper
 *
 * Allows objects to be created directly from an array of data, mapping keynames in the array to member
 * variable names.
 *
 * @package Intahwebz\FlickrGuzzle
 */
trait DataMapper {

	/**
	 * @param $data
	 * @return static An instance of the class that the trait is used in. 'Static' is meant to be the 'late static class' - not many IDEs support this DOC comment yet.
	 * @throws \Exception
	 */
	static function createFromJson($jsonData){
		if (property_exists(__CLASS__, 'dataMap') == FALSE){
			throw new \Exception("Class ".__CLASS__." is using DataMapper but has not set DataMap.");
		}

		$instance = new static();
		$instance->mapValuesFromData($jsonData);
		return $instance;
	}

	/**
	 * @param $data
	 * @throws \Exception
	 */
	function mapValuesFromData($data){
		foreach(static::$dataMap as $dataMapElement){
			if (is_array($dataMapElement) == FALSE) {
				$string = var_export(static::$dataMap, TRUE);
				throw new \Exception("DataMap is meant to be composed of arrays of entries. You've missed some brackets in class ".__CLASS__." : ".$string);
			}

			$sourceValue = self::getValueFromData($data, $dataMapElement);
			$this->setPropertyValue($dataMapElement, $sourceValue);
		}
	}

	/**
	 * Look in the $data for the value to be used for the mapping according to the rules set in $dataMapElement.
	 *
	 * @param $data
	 * @param $dataMapElement
	 * @return array|null
	 * @throws \Exception
	 */
	static function getValueFromData($data, $dataMapElement){
		$dataVariableNameArray = $dataMapElement[1];
		if ($dataVariableNameArray == NULL) {
			//value is likely to be a class that has been merged into the Json at the root level,
			//so pass back same array, so that the class that will be instantiated has access to all of it.
			return $data;
		}

		if(is_array($dataVariableNameArray) == FALSE){
			$dataVariableNameArray = array($dataVariableNameArray);
		}

		$value = $data;

		foreach($dataVariableNameArray as $dataVariableName){
			if (is_array($value) == FALSE ||
				array_key_exists($dataVariableName, $value) == FALSE){
				if (array_key_exists('optional', $dataMapElement) == TRUE &&
					$dataMapElement['optional'] == TRUE){
					return NULL;
				}
				//var_dump($data);
				//var_dump($dataMapElement);

				$dataPath = implode('->', $dataVariableNameArray);
				throw new \Exception("DataMapper cannot find value from $dataPath in source JSON to map to actual value in class ".__CLASS__);
			}

			$value = $value[$dataVariableName];
		}

		$value = self::unindexValue($value, $dataMapElement);
		return $value;
	}


	/**
	 * Unindex arrays to plain values if required. e.g. change
	 * $title = array('_content' => 'Actual title');
	 * to
	 * $title = 'Actual title';
	 *
	 * @param $value
	 * @param $dataMapElement
	 * @return array
	 */
	public static function unindexValue($value, $dataMapElement){

		if (array_key_exists('unindex', $dataMapElement) == TRUE) {
			$index = $dataMapElement['unindex'];
			if (is_array($value)) {
				if (array_key_exists($index, $value) == TRUE) {
					$value = $value[$index];
				}
			}
		}

		return $value;
	}


	/**
	 * Apply the value (or array of values) retrieved from Json and apply it to the instances property. If
	 * the value represent a class, instantiate that class and map it's variables before setting it as the
	 * properties value.
	 *
	 * @param $dataMapElement
	 * @param $sourceValue
	 */
	function setPropertyValue($dataMapElement, $sourceValue){
		$classVariableName = $dataMapElement[0];
		$className = FALSE;
		$multiple = FALSE;

		if(array_key_exists('class', $dataMapElement) == TRUE){
			$className = $dataMapElement['class'];
		}
		if(array_key_exists('multiple', $dataMapElement) == TRUE){
			$multiple = $dataMapElement['multiple'];
		}

		if($multiple == TRUE){
			$this->{$classVariableName} = array();

			foreach($sourceValue as $sourceValueInstance){
				if($className != FALSE){
					$object = $className::createFromJson($sourceValueInstance);
					$this->{$classVariableName}[] = $object;
				}
				else{
					$this->{$classVariableName}[] = $sourceValueInstance;
				}
			}
		}
		else{
			if($className != FALSE){
				$object = $className::createFromJson($sourceValue);
				$this->{$classVariableName} = $object;
			}
			else{
				$this->{$classVariableName} = $sourceValue;
			}
		}
	}
}