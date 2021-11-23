<?php

// Написать класс Complex, который представляет собой комплексное число. Класс должен содержать:

//     Конструктор __construct($__real, $__imaginary);
//     Метод set_real($__real);
//     Метод set_imaginary($imaginary);
//     Метод get_real();
//     Метод get_imaginary();
//     Метод module(), рассчитывающий модуль комплексного числа;
//     Метод get_arg(), рассчитывающий аргумент комплексного числа;
//     Метод set_coordinates($module, $arg), устанавливающий свойства в соответствии с заданными параметрами;
//     Метод pow_complex($degree), возводящий комплексное число в степень $degree;
//     Метод add($parameters_other), рассчитывающий сумму двух комплексных чисел.;
//     Метод composition($parameters_other), рассчитывающий проивзедение двух комплексных чисел.;
//     Метод reverse_element(), рассчитывающий обратный в поле комплексных чисел. Вернуть сериализованную строку.
//     Метод division($parameters_other), рассчитывающий деление в поле комплексных чисел.;
//     Свойство(private) $__real
//     Свойство(private) $__imaginary

// Важно! $parameters_other - массив параметров объека с которым складываем или находим произведение:
// соответственно в [0] лежит real, в [1] лежит imaginary! К свойствам можно обращаться только через методы. Все методы public

// Отнаследовать от класса Complex класс Real, необходимо:

//     Переопределить конструктор(мнимая составляющая всегда 0);
//     Переопределить матод сложения действительных чисел add($other),
//         теперь представление не в виде упорядоченной пары, а в виде чисел;
//     Переопределить матод умножения действительных чисел composition($other),
//         теперь представление не в виде упорядоченной пары, а в виде чисел;

class Complex
{
    private $__real;
    private $__imaginary;

    function __construct($__real, $__imaginary)
    {
        $this -> __real      = $__real;
        $this -> __imaginary = $__imaginary;
    }

    function set_real($__real)
    {
        $this -> __real = $__real;
    }

    function set_imaginary($__imaginary)
    {
        $this -> __imaginary = $__imaginary;
    }

    function get_real()
    {
        return $this -> __real;
    }

    function get_imaginary()
    {
        return $this -> __imaginary;
    }

    function module()
    {
        return sqrt(pow($this -> __real, 2) + pow($this -> __imaginary, 2));
    }

    function get_arg()
    {
        return atan($this -> __imaginary / $this -> __real);
    }

    function set_coordinates($module, $arg)
    {
        $this -> __real      = $module * cos($arg);
        $this -> __imaginary = $module * sin($arg);
    }

    function pow_complex($degree)
    {
        $mod = $this -> module();
        
    }
}
