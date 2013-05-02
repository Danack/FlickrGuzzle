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

	static function getValueFromAlias($data, $dataMapElement, $optional){

		$dataVariableNameArray = $dataMapElement[1];

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

			if (is_array($dereferenced) == false ||
				//Probably an element that can exist as different entries e.g. for tags
				//[raw]
				//or [raw, _content]
				array_key_exists($dataVariableName, $dereferenced) == FALSE){
//				$notSet = TRUE;
//				return FALSE;
				if ($optional == false) {
//					$alias = $dataMapElement[1];//$dataVariableNameArray;
//
//					if(is_array($alias) == TRUE){
//						$alias = implode('->', $alias);
//					}
//
					var_dump($data);
					//TODO - actuall do this.
//					//$dataString = implode(',', $data);

					throw new \Exception("DataMapper cannot find value from  for mapping to actual value in array ");
				}

			}
			$dereferenced = $dereferenced[$dataVariableName];
		}

		if (array_key_exists('unindex', $dataMapElement) == true) {
			$index = $dataMapElement['unindex'];

			//Amazingly sometimes text is returned as $title['_content'] = $text other
			//times it's just $title = $text
			if (is_array($dereferenced)) {
				if (array_key_exists($index, $dereferenced) == true) {
					$dereferenced = $dereferenced[$index];
				}
			}
		}

		return $dereferenced;
	}

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
		$count = 0;

		foreach(static::$dataMap as $dataMapElement){

			$classVariableName = $dataMapElement[0];
			$className = FALSE;
			$multiple = FALSE;

			if (is_array($dataMapElement) == false) {
				$string = var_export(static::$dataMap, true);
				throw new \Exception("DataMap is meant to be composed of arrays of entries. You've missed some brackets in class ". __CLASS__." : ".$string);
			}

			if(array_key_exists('class', $dataMapElement) == TRUE){
				$className = $dataMapElement['class'];
			}
			if(array_key_exists('multiple', $dataMapElement) == TRUE){
				$multiple = $dataMapElement['multiple'];
			}

			//$notFound = FALSE;

			$optional = false;

			if (array_key_exists('optional', $dataMapElement) == true &&
				$dataMapElement['optional'] == true){
				$optional = true;
			}

			$sourceValue = self::getValueFromAlias($data, $dataMapElement, $optional);

//			if($notFound == TRUE){
//				if (array_key_exists('optional', $dataMapElement) == TRUE &&
//					$dataMapElement['optional'] == TRUE){
//					continue;
//				}
//
//				$alias = $dataMapElement[1];//$dataVariableNameArray;
//
//				if(is_array($alias) == TRUE){
//					$alias = implode('->', $alias);
//				}
//
//				var_dump($data);
//				//$dataString = implode(',', $data);
//
//				throw new \Exception("DataMapper cannot find value from [".$alias."] for mapping to actual value in array ");
//				//.var_export($data)
//			}

			$this->setPropertyValue($classVariableName, $sourceValue, $className, $multiple);

			$count++;
		}
	}


	function setPropertyValue($classVariableName, $sourceValue, $className, $multiple){
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