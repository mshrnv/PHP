<?php

// Написать класс Fraction, который представляет собой дробное число
// Класс должен содержать:

// Конструктор __construct($numerator, $denomerator);
// Метод set_numerator($numerator);
// Метод set_denomerator($denomerator);
// Метод get_numerator();
// Метод get_denomerator();
// Метод redution(), сокращающий дробь;
// Метод add($parameters_other), рассчитывающий сумму двух дробей,
// возвращается сокращенный вариант. Результат сохраняется в объект вызываемого метода;
// Метод composition($parameters_other), рассчитывающий проивзедение двух двух дробей,
// возвращается сокращенный вариант. Результат сохраняется в объект вызываемого метода;
// Свойство(private) $__numerator
// Свойство(private) $__denomerator
// К свойствам можно обращаться только через методы. Все методы public.
// Если знаменатель равен 0, то вернуть предупреждение 'На ноль делить нельзя!'

class Fraction
{
    private $__numerator, $__denomerator;

    function __construct($numerator, $denomerator)
    {
        $this -> __numerator   = $numerator;
        $this -> __denomerator = $denomerator;
    }

    function set_numerator($numerator)
    {
        $this -> __numerator = $numerator;
    }

    function set_denomerator($denomerator)
    {
        $this -> __denomerator = $denomerator;
    }

    function get_numerator()
    {
        return $this -> __numerator;
    }

    function get_denomerator()
    {
        return $this -> __denomerator;
    }

    function redution()
    {
        $nod = gmp_intval(gmp_gcd($this -> __numerator, $this -> __denomerator));
        $this -> __numerator /= $nod;
        $this -> __denomerator /= $nod;
    }

    function add($parameters_other)
    {
        $this -> __numerator += $parameters_other[0];
        $this -> __denomerator += $parameters_other[1];
        $this -> redution();
    }

    function composition($parameters_other)
    {
        $res = ($this -> __numerator / $this -> __denomerator) * ($parameters_other[0] / $parameters_other[1]);
        if (abs($res) >= 1) {
            $this -> __numerator = $res;
        } else {
            $this -> __numerator = 1/$res;
        }
        $this -> __denomerator = 1;
        $this -> redution();
    }
}