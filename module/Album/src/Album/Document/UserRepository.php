<?php
namespace Album\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

use Doctrine\ODM\MongoDB\DocumentRepository;

class UserRepository extends DocumentRepository
{
	public function findUserById($id)
	{
		return $this->findOneBy(array('id' => $id));
	}
	public function findUserByName($name)
	{
		return $this->findOneBy(array('name' => $name));
	}
	public function findAll()
	{
		return $this->findAll();
	}
}

