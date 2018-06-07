<?php
namespace App\Entities\Owners;

use App\Contracts\OwnerInterface;
use App\Contracts\AnimalInterface;

/**
 * @author Artemy Polenko
 */
class AnimalShelter
{
    /**
     * @var array Карта животных.
     */
    private $animalMap;

    /**
     * @var integer Предыдущий идентификатор животного.
     */
    private $prevAnimalId;

    public function __construct()
    {
        $this->animalMap = Array();
        $this->prevAnimalId = 0;
    }

    /**
     * @param AnimalInterface $animal Животное.
     */
    public function addAnimal(AnimalInterface $animal)
    {
        $animal->setId(++$this->prevAnimalId);
        $animal->setHomeless();
        $animalType = get_class($animal);
        if (!key_exists($animalType, $this->animalMap)) {
            $this->animalMap[$animalType] = Array();
        }
        array_push($this->animalMap[get_class($animal)], $animal);
    }

    /**
     * @param AnimalInterface $el1 Животное 1.
     * @param AnimalInterface $el2 Животное 2.
     * @return integer Результат сравнения.
     */
    private function sortByNameCallback($el1, $el2)
    {
        if ($el1->getName() == $el2->getName()) {
            return 0;
        }
        return ($el1->getName() < $el2->getName()) ? -1 : 1;
    }

    /**
     * @param AnimalInterface $el1 Животное 1.
     * @param AnimalInterface $el2 Животное 2.
     * @return integer Результат сравнения.
     */
    private function sortByIdCallback($el1, $el2)
    {
        if ($el1->getId() == $el2->getId()) {
            return 0;
        }
        return ($el1->getId() < $el2->getId()) ? -1 : 1;
    }

    /**
     * @param array $animals Массив животных.
     *
     * @return array Массив животных.
     */
    private function sortByName($animals)
    {
        usort($animals, array(self::class, 'sortByNameCallback'));
        return $animals;
    }

    /**
     * @param array $animals Массив животных.
     *
     * @return array Массив животных.
     */
    private function sortById($animals)
    {
        usort($animals, array(self::class, 'sortByIdCallback'));
        return $animals;
    }
    
    /**
     * @param string $animalType Класс животного.
     *
     * @return array Список животных по выбранному типу.
     */
    public function getAnimalsByType($animalType)
    {
        if (key_exists($animalType, $this->animalMap)) {
            return $this->sortByName($this->animalMap[$animalType]);
        }
        return [];
    }

    /**
     * Отдаем любое животное с наибольшим сроком пребывания.
     *
     * @param OwnerInterface $owner Владелец.
     *
     * @return AnimalInterface|null Животное.
     */
    public function giveAnimalTo(OwnerInterface $owner)
    {
        foreach (array_keys($this->animalMap) as $typedArray) {
            $this->sortById($this->animalMap[$typedArray]);
        }
        $animalType =  $this->getGreatestIdType();
        $animal = array_shift($this->animalMap[$animalType]);
        $animal->setOwner($owner);
        return $animal;
    }

    /**
     * Отдаем животное определенного класса с наибольшим сроком пребывания.
     *
     * @param OwnerInterface $owner Владелец.
     * @param string Класс животного.
     *
     * @return AnimalInterface|null Животное.
     */
    public function giveAnimalByTypeTo(OwnerInterface $owner, $animalType)
    {
        $this->sortById($this->animalMap[$animalType]);
        $animal = array_shift($this->animalMap[$animalType]);
        $animal->setOwner($owner);
        return $animal;
    }

    /**
     * @return string Класс животного.
     */
    private function getGreatestIdType()
    {
        $resultAnimal = null;
        $animals = $this->animalMap;
        foreach (array_keys($this->animalMap) as $typedArray) {
            $animal = array_shift($animals[$typedArray]);
            if (!isset($resultAnimal)) {
                $resultAnimal = $animal;
            } else if ($resultAnimal->getId() > $animal->getId()) {
                $resultAnimal = $animal;
            }
        }
        return get_class($resultAnimal);
    }

    /**
     * @return array Массив животных.
     */
    public function getAnimals()
    {
        return $this->animalMap;
    }
}