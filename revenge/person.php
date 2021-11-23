<?php

// Написать класс Person, который представляет собой данные о человеке
// Класс должен содержать:
//     Конструктор __construct($name, $age, $height, $weight);
//     Методы get_name(), get_age(), get_height(), get_weight();
//     Метод change_name($newName), изменяющий имя;
//     Метод add_weight($weight), увеличивающий вес на величину $weight;
//     Метод lose_weight($weight), уменьшающий вес;
//     Метод get_bmi(), рассчитывающий индекс массы по формуле (вес / (рост в метрах)^2);
//     Свойства $__name, $__age, $__height, $__weight;
// К свойствам можно обращаться только через методы

class Person
{
    private $__name, $__age, $__height, $__weight;

    function __construct($name, $age, $height, $weight)
    {
        $this -> __name   = $name;
        $this -> __age    = $age;
        $this -> __height = $height;
        $this -> __weight = $weight;
    }

    function get_name()
    {
        return $this -> __name;
    }

    function get_age()
    {
        return $this -> __age;
    }

    function get_height()
    {
        return $this -> __height;
    }

    function get_weight()
    {
        return $this -> __weight;
    }

    function change_name($newName)
    {
        $this -> __name = $newName;
    }

    function add_weight($weight)
    {
        $this -> __weight += $weight;
    }

    function lose_weight($weight)
    {
        $this -> __weight -= $weight;
    }

    function get_bmi()
    {
        return $this -> __weight / pow($this -> __height / 100, 2);
    }
}