<?php

// Написать класс Battle, который представляет собой пошаговое сражение двух сторон и класс Unit,
// представляющий собой боевой юнит.
// Класс Unit должен содержать:

//     Конструктор __construct($health, $damage), создающий юнита с соответствующим уровнем жизней и уроном;
//     Методы getHealth(), getDamage(), возвращающие информацию о юните;
//     Метод hit($damage), наносящий юниту урон в размере $damage;

// Класс Battle должен содержать:

//     Конструктор __construct();
//     Методы joinToAllies($unit), joinToEnemies($unit), которые присоединяют юнит к одной из команд
//     Методы getAlliesCount(), getEnemiesCount(), возвращающие количество юнитов в командах;
//     Метод fight(), инициализирующий сражение. Во время него рассчитывается суммарный урон каждой команды,
//     который затем наносится каждому юниту противоположной команды в равных количествах
//     (суммарный урон делится на количество юнитов противника с округлением вниз до целого).
//     Если здоровье юнита становится меньше 0, он удаляется из команды
//     Свойства $__allies, $__enemies - массивы юнитов;

// К свойствам можно обращаться только через методы

class Battle
{
    private $__allies;
    private $__enemies;

    function __construct($allies, $enemies)
    {
        $this->__allies  = $allies;
        $this->__enemies = $enemies;
    }

    function joinToAllies($unit)
    {
        $this->__allies[] = $unit;
    }

    function joinToEnemies($unit)
    {
        $this->__enemies[] = $unit;
    }

    function getAlliesCount()
    {
        return count($this->__allies);
    }

    function getEnemiesCount()
    {
        return count($this->__enemies);
    }

    function fight()
    {
        $attack  = '__allies';
        $defence = '__enemies';

        for($i = 0;$i < 4; $i++) {
            $summaryDamage = 0;
            foreach ($this -> $attack as $unit) {
                $summaryDamage += $unit->getDamage();
            }

            $damagePerUnit = intval($summaryDamage / count($this->$defence));
            $died = array();
            foreach ($this -> $defence as $unit) {
                $unit->hit($damagePerUnit);
                if ($unit->getHealth() < 0) {
                    $died[] = $unit;
                }
            }

            $this -> $defence = array_diff($this -> $defence, $died);

            $temp    = $attack;
            $attack  = $defence;
            $defence = $temp;
        }
    }
}

class Unit
{
    private $__health;
    private $__damage;

    function __construct($health, $damage)
    {
        $this -> __health = $health;
        $this -> __damage = $damage;
    }

    function getHealth()
    {
        return $this->__health;
    }

    function getDamage()
    {
        return $this->__damage;
    }

    function hit($damage)
    {
        $this->__health = $this->__health - $damage;
    }
}