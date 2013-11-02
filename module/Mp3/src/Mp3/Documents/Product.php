<?php

namespace Mp3\Documents;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @Document */
class Product
{
	/** @Id */
	private $id;

	/** @String */
	private $title;

	/** @String */
	private $keyword = array();

	public function getId()
	{
		return $this->id;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function setTitle($title)
	{
		$this->title = $title;
	}

	public function addKeyword($keyword)
	{
		array_push($this->keyword, $keyword);
	}
}