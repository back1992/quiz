<?php
namespace Application\Entity;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class User {
	/**
	* @ORM\Id
	* @ORM\GeneratedValue(strategy='AUTO')
	* @ORM\Column(type="integer")
	*/
	protected $id;

	/** @ORM\Column(type="string") */
	protected $fullName;

	//getters/setters

    /**
     * Gets the value of fullName.
     *
     * @return mixed
     */
    public function getFullName()
    {
        return $this->fullName;
    }
    
    /**
     * Sets the value of fullName.
     *
     * @param mixed $fullName the full name
     *
     * @return self
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }
}