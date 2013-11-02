<?php

namespace Mp3\Documents;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;


/** @Document */
class User
{

/** 
 * @Id(strategy="UUID") 
 */
private $id;

/** 
 * @Field(type="string") 
 */
private $name;

/** 
 * @Field(type="string") 
 */
private $firstname;

public function get($property) 
{
	$method = 'get'.ucfirst($property);
	if (method_exists($this, $method))
	{
		return $this->$method();
	} else {
		$propertyName = $property;
		return $this->$propertyName;
	}           
}

public function set($property, $value) 
{
	$method = 'set'.ucfirst($property);
	if (method_exists($this, $method))
	{
		$this->$method($value);
	} else {
		$propertyName = $property;                
		$this->$propertyName = $value;
	}
}    
}