<?php
namespace App\Contracts;

/**
 * @author Artemy Polenko
 */
interface AnimalInterface
{
    /**
     * @param string  $name Кличка животного.
     * @param integer $age  Возраст.
     */
    public function __construct($name, $age);

    //Getters
    /**
     * @return string Кличка.
     */
    public function getName();

    /**
     * @return integer Возраст.
     */
    public function getAge();

    /**
     * @return integer Идентификатор.
     */
    public function getId();

    /**
     * @return OwnerInterface|null Владелец.
     */
    public function getOwner();

    //Setters
    /**
     * @param OwnerInterface $owner Владелец животного.
     */
    public function setOwner(OwnerInterface $owner);

    /**
     * @return null
     */
    public function setHomeless();

    /**
     * @param integer $id Идентификатор животного.
     */
    public function setId($id);
}