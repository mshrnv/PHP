<?php

// Написать класс Rectangle, который представляет собой прямоугольник
// Класс должен содержать:

//     Конструктор __construct($width, $height);
//     Метод set_width($width);
//     Метод set_height($height);
//     Методы get_width(), get_height();
//     Метод get_square(), рассчитывающий площадь прямоугольника;
//     Метод to_string(), выводящий сведения об объекте в формате "width: x; height: y";
//     Приватные свойства $__width, $__height;

// К свойствам можно обращаться только через методы

class Rectangle
{
    private $__width, $__height;

    function __construct($width, $height)
    {
        $this -> __width  = $width;
        $this -> __height = $height;
    }

    function set_width($width)
    {
        $this -> __width = $width;
    }

    function set_height($height)
    {
        $this -> __height = $height;
    }

    function get_width()
    {
        return $this -> __width;
    }

    function get_height()
    {
        return $this -> __height;
    }

    function get_square()
    {
        return $this -> __height * $this -> __width;
    }

    function to_string()
    {
        return "width: {$this -> __width}; height: {$this -> __height}";
    }
}