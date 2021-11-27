<?php

// Написать класс Input, выводящий html код input-элемента и классы Button и Text,
// расширяющие его:

// Класс Input должен содержать:

//     Конструктор __construct($type, $name, $value);
//     Методы setType($type), setName($name), setValue($value);
//     Метод get(), выводящий html код данного элемента с учетом свойств класса;
//     Приватные свойства $__type, $__name, $__value;

// В классах Button и Text метод setType не переопределяется.
// К свойствам можно обращаться только через методы

class Input
{
    private $__type, $__name, $__value;

    function __construct($type, $name, $value)
    {
        $this->__type  = $type;
        $this->__name  = $name;
        $this->__value = $value;
    }

    function setType($type)
    {
        $this->__type = $type;
    }

    function setName($name)
    {
        $this->__name = $name;
    }

    function setValue($value)
    {
        $this->__value = $value;
    }

    function get()
    {
        return '<input type="'.$this->__type.'" name="'.$this->__name.'" value="'.$this->__value.'">';
    }
}

class Button extends Input
{
    private $__type, $__name, $__value;

    function __construct($name, $value)
    {
        $this->__name  = $name;
        $this->__value = $value;
        $this->__type = 'button';
    }
}

class Text extends Input
{
    private $__type, $__name, $__value;

    function __construct($name, $value)
    {
        $this->__name  = $name;
        $this->__value = $value;
        $this->__type = 'text';
    }
}
