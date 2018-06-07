<?php
namespace App\Common;

use App\Contracts\OwnerInterface;
use App\Contracts\AnimalInterface;

/**
 * @author Artemy Polenko
 */
class AnimalBase implements AnimalInterface
{
    /**
     * @var string Кличка.
     */
    private $name;

    /**
     * @var integer Возраст.
     */
    private $age;

    /**
     * @var integer Идентификатор.
     */
    private $id;

    /**
     * @var OwnerInterface Владелец.
     */
    private $owner;

    /**
     * {@inheritdoc}
     */
    public function __construct($name, $age)
    {
        $this->name = $name;
        $this->age  = $age;
    }

    //Getters
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getOwner()
    {
        return $this->owner;
    }

    //Setters
    /**
     * {@inheritdoc}
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     */
    public function setOwner(OwnerInterface $owner)
    {
        $this->owner = & $owner;
    }

    public function setHomeless()
    {
        unset($this->owner);
    }
}