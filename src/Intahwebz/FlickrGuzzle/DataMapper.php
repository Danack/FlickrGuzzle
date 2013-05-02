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
	 * @return static
	 * @throws \Exception
	 */
	static function createFromJson($jsonData){
		if (property_exists(__CLASS__, 'dataMap') == FALSE){
			throw new \Exception("Class ".__CLASS__." is using DataMapper but has not set DataMap.");
		}

		$instance = new static();
		$instance->mapValuesFromJson($jsonData);
		return $instance;
	}


	function mapValuesFromJson($data){
		foreach(static::$dataMap as $dataMapElement){
			if (is_array($dataMapElement) == false) {
				$string = var_export(static::$dataMap, true);
				throw new \Exception("DataMap is meant to be composed of arrays of entries. You've missed some brackets in class ".__CLASS__." : ".$string);
			}

			$sourceValue = self::getValueFromAlias($data, $dataMapElement);
			$this->setPropertyValue($dataMapElement, $sourceValue);
		}
	}

	static function getValueFromAlias($data, $dataMapElement){

		$dataVariableNameArray = $dataMapElement[1];

		if ($dataVariableNameArray == null) {
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
				if (array_key_exists('optional', $dataMapElement) == true &&
					$dataMapElement['optional'] == true){
					return null;
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


	//Amazingly sometimes text is returned as $title['_content'] = $text other
	//times it's just $title = $text
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




	function setPropertyValue($dataMapElement, $sourceValue){

		$classVariableName = $dataMapElement[0];
		$className = false;
		$multiple = false;

		if(array_key_exists('class', $dataMapElement) == true){
			$className = $dataMapElement['class'];
		}
		if(array_key_exists('multiple', $dataMapElement) == true){
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