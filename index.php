<?php

/*
 |-----------------------------------------------------------------------------
 | Загружаем необходимые для работы файлы
 |-----------------------------------------------------------------------------
 */
require_once __DIR__ . DIRECTORY_SEPARATOR . 'autoload.php';

$autoloader = new App();
$autoloader->addNamespace('App', __DIR__);
$autoloader->register();

/*
 |-----------------------------------------------------------------------------
 | Подключаем необходимые для работы пространства имен
 |-----------------------------------------------------------------------------
 */
use App\Entities\Animals\Cat;
use App\Entities\Animals\Dog;
use App\Entities\Owners\Person;
use App\Entities\Animals\Turtle;
use App\Entities\Owners\AnimalShelter;

/*
 |-----------------------------------------------------------------------------
 | Функции для упрощения вывода
 |-----------------------------------------------------------------------------
 */
function printAnimalNames($animals)
{
    foreach ($animals as $animal) {
        printf("\t%s\n", $animal->getName());
    }
}

/*
 |-----------------------------------------------------------------------------
 | Демонстрация работы питомника
 |-----------------------------------------------------------------------------
 */
$animalShelter = new AnimalShelter();

//Создаем экземпляры котиков.
$cat_1      = new Cat('Felix', 3);
$cat_2      = new Cat('Kitty', 5);

//Создаем экземпляры собак.
$dog_1      = new Dog('Lucy', 1);
$dog_2      = new Dog('Molly', 7);

//Создаем экземпляры черепах.
$turtle_1   = new Turtle('Jake', 11);
$turtle_2   = new Turtle('Apollo', 9);

//Создаем экземпляры людей, которые заберут животных.
$person_1   = new Person('Jack');
$person_2   = new Person('Monica');

//Работаем с питомником.
$animalShelter->addAnimal($cat_2);
$animalShelter->addAnimal($dog_1);
$animalShelter->addAnimal($turtle_1);

$animalShelter->addAnimal($cat_1);
$animalShelter->addAnimal($dog_2);
$animalShelter->addAnimal($turtle_2);

//Берем всех животных по типу.
printf("Cats in Animal Shelter: \n");
printAnimalNames($animalShelter->getAnimalsByType(Cat::class));
printf("%s\n", str_repeat('-', 30));

printf("Dogs in Animal Shelter: \n");
printAnimalNames($animalShelter->getAnimalsByType(Dog::class));
printf("%s\n", str_repeat('-', 30));

printf("Turtles in Animal Shelter: \n");
printAnimalNames($animalShelter->getAnimalsByType(Turtle::class));
printf("%s\n", str_repeat('-', 30));

//Передаем животное определенного типа человеку
// P.S: Видно, что первым мы добавляли $cat_2,
//      Значит он дольше всех находится здесь,
//      и именно его должен питомник вернуть.
$animal = $animalShelter->giveAnimalTo($person_1);
printf(
    "Person: \"%s\" has been owner to \"%s\"\n%s\n",
    $animal->getOwner()->getOwnerName(), $animal->getName(), str_repeat('-', 30)
);

// P.S: Возмем еще одно животное, можем предположить
//      что нам должен вернуть питомник, это dog_1,
//      потому что он был добавлен вторым, а первого
//      животного у нас уже в системе нет.
$animal = $animalShelter->giveAnimalTo($person_1);
printf(
    "Person: \"%s\" has been owner to \"%s\"\n%s\n",
    $animal->getOwner()->getOwnerName(), $animal->getName(), str_repeat('-', 30)
);

//Теперь передадим во владение животное определенного типа.
$animal = $animalShelter->giveAnimalByTypeTo($person_2, Turtle::class);
printf(
    "Person: \"%s\" has been owner to \"%s\"\n%s\n",
    $animal->getOwner()->getOwnerName(), $animal->getName(), str_repeat('-', 30)
);

//Ну и напоследок выведем оставшихся животных, чтобы убедиться, что у нас
//не осталось мертвых душ и лапок. Троих мы отдали, получается должно было
//остаться трое.
print_r($animalShelter->getAnimals());

/*
 |-----------------------------------------------------------------------------
 | Примечания к работе:
 |  1. Все, что связанно с сортировкой не должно быть частью класса AnimalShelter
 |     потому как это противоречит SOLID-концепции.
 |  2. Такой способ хранения животных выбран не случайно:
 |      так мы избавляемся от всяческих констант и можем не отслеживать появление
 |      новых видов животных.
 |  3. Лучше бы унаследовать AnimalShelter от OwnerInterface и создать отдельный
 |      сервис управления всей этой схемой, чтобы унифицировать код и не зависеть
 |      от реализации AnimalShelter. Получается мы сможем иметь журнал всего
 |      оборота пушистых лап и остальных мимимишек.
 |-----------------------------------------------------------------------------
 */