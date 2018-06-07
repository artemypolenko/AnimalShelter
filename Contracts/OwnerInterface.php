<?php
namespace App\Contracts;

/**
 * @author Artemy Polenko
 */
interface OwnerInterface
{
    /**
     * @return string Имя владельца.
     */
    public function getOwnerName();
}
