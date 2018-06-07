<?php
namespace App\Entities\Owners;

use App\Contracts\OwnerInterface;

/**
 * @author Artemy Polenko
 */
class Person implements OwnerInterface
{
    /**
     * @var string Имя владельца.
     */
    private $name;

    public function __construct($name)
    {
       $this->name = $name;
    }

    /**
     * @return string Имя владельца.
     */
    public function getOwnerName()
    {
        return $this->name;
    }
}
