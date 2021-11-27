<?php

// Написать класс HardWorker, который представляет собой работника. Класс должен содержать:

//     Конструктор __construct($age, $salary, $jobs);
//     Метод set_age($age);
//     Метод set_salary($salary);
//     Метод set_jobs($jobs);
//     Метод get_age();
//     Метод get_salary();
//     Метод get_jobs();
//     Метод funny(), который вычитает из денежных средств 10000;
//     Свойство(private) $__age, возраст.;
//     Свойство(private) $__salary, количество денежных средств.;
//     Свойство(private) $__jobs, количество заказов.;

// К свойствам можно обращаться только через методы. Все методы public.

// С помощью включений реализовать классы: Plumber и Programmer. Класс Plumber должен содержать:

//     Конструктор __construct($age, $salary, $jobs);
//     Метод worked(), увеличивает количество заказов на 5, денежные средства на 1000, а возраст на полгода.;
//     Метод ate(), уменьшает количество заказов на 2, денежные средства на 500;
//     Метод sleep(), уменьшает количество заказов на 5.
//     Свойство(private) $__plumber.

// Класс Programmer должен содержать:

//     Конструктор __construct($age, $salary, $jobs);
//     Метод worked(), увеличивает количество заказов на 1000000, денежные средства на 10000,
//         а возраст на 10 лет.;
//     Метод ate(), уменьшает количество заказов на 1, денежные средства на 700;
//     Метод sleep(), уменьшает количество заказов на 1.;
//     Свойство(private) $__programmer.;

// При включении классов, сохранить все исходные методы в целевых классах.

class HardWorker
{
    private $__age, $__salary, $__jobs;

    function __construct($age, $salary, $jobs)
    {
        $this->__age    = $age;
        $this->__salary = $salary;
        $this->__jobs   = $jobs;
    }

    function set_age($age)
    {
        $this->__age = $age;
    }

    function set_salary($salary)
    {
        $this->__salary = $salary;
    }

    function set_jobs($jobs)
    {
        $this->__jobs = $jobs;
    }

    function get_age()
    {
        return $this->__age;
    }

    function get_salary()
    {
        return $this->__salary;
    }

    function get_jobs()
    {
        return $this->__jobs;
    }

    function funny()
    {
        $this->__salary -= 10000;
    }
}

class Plumber extends HardWorker
{

    private $__plumber;

    function __construct($age, $salary, $jobs)
    {
        // $this -> __plumber -> set_age($age);
        // $this -> __plumber -> set_salary($salary);
        // $this -> __plumber -> set_jobs($jobs);

        $this -> __plumber = new HardWorker($age, $salary, $jobs);
    }

    function set_salary($salary)
    {
        parent::set_salary($salary);
    }

    function set_age($age)
    {
        parent::set_age($age);
    }

    function set_jobs($jobs)
    {
        parent::set_jobs($jobs);
    }

    function get_jobs()
    {
        parent::get_jobs();
    }

    function get_salary()
    {
        parent::get_salary();
    }

    function get_age()
    {
        parent::get_age();
    }

    function funny()
    {
        parent::funny();
    }

    function worked()
    {
        $this->__jobs   += 5;
        $this->__salary += 1000;
        $this->__age    += 0.5;
    }

    function ate()
    {
        $this->__jobs   -= 2;
        $this->__salary -= 500;
    }

    function sleep()
    {
        $this->__jobs -= 5;
    }
}

class Programmer extends HardWorker
{
    private $__programmer;

    function __construct($age, $salary, $jobs)
    {
        parent::__construct($age, $salary, $jobs);
    }

    function set_salary($salary)
    {
        parent::set_salary($salary);
    }

    function set_age($age)
    {
        parent::set_age($age);
    }

    function set_jobs($jobs)
    {
        parent::set_jobs($jobs);
    }

    function get_jobs()
    {
        parent::get_jobs();
    }

    function get_salary()
    {
        parent::get_salary();
    }

    function get_age()
    {
        parent::get_age();
    }

    function funny()
    {
        parent::funny();
    }

    function worked()
    {
        $this->__jobs   += 1000000;
        $this->__salary += 10000;
        $this->__age    += 10;
    }

    function ate()
    {
        $this->__jobs   -= 1;
        $this->__salary -= 700;
    }

    function sleep()
    {
        $this->__jobs -= 1;
    }
}