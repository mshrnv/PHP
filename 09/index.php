<?php

#Подключаем шаблонизатор
require_once 'Template.php';

#Определение констант
define('STEP', 50);
define('TEMPLATE_FILE_PATH', './templates/index.html');
define('COLOR_RANGE', 210);

#Массив машин
$carsArr = array(
    array('manufactor' => 'BMW', 'model' => 'Smart', "hp" => 45),
    array('manufactor' => 'BMW', 'model' => 'X1', "hp" => 50),
    array('manufactor' => 'Mazda', 'model' => '6', "hp" => 55),
    array('manufactor' => 'Mazda', 'model' => '3', "hp" => 65),
    array('manufactor' => 'Hyundai', 'model' => 'i30', "hp" => 120),
    array('manufactor' => 'Lada', 'model' => 'Granta', "hp" => 170),
    array('manufactor' => 'Lada', 'model' => 'Granta Turbo', "hp" => 190),
    array('manufactor' => 'Toyota', 'model' => 'Camry', "hp" => 249),
    array('manufactor' => 'Mercedes-Benz', 'model' => 'E63s', "hp" => 580),
);

#Массив цветов
$colorsArr = array('lightcoral', 'yellow', 'lightgreen', 'lightblue', 'purple');

#Распределяем все машины по группам лошадиных сил
$carGroupsArr = array();
foreach ($carsArr as $carArr) {
    $carGroupsArr[getHpGroup($carArr['hp'])][$carArr['manufactor']][] = $carArr;
}

$colorStep = COLOR_RANGE / (count($carGroupsArr) - 1);

#Формирование массива для шаблонизатора
$groupCounter = 0;
$color        = 0;
foreach ($carGroupsArr as $hpGroup => $carGroup) {
    $manufactorCounter = 0;
    foreach ($carGroup as $manufactor => $cars) {

        # Для каждой марки определяем массив моделей этой марки, производителя
        # И количество моделей машин этой марки в текущей группе
        $templateDataArr['car_group'][$groupCounter]['manufactor'][$manufactorCounter]['model']      = $cars;
        $templateDataArr['car_group'][$groupCounter]['manufactor'][$manufactorCounter]['manufactor'] = $manufactor;
        $templateDataArr['car_group'][$groupCounter]['manufactor'][$manufactorCounter]['rowspan']    = count($cars);
        $manufactorCounter++;
    }

    #Каждой группе машин определяем ее название(например: '100-150') и цвет
    $templateDataArr['car_group'][$groupCounter]['hp_group'] = $hpGroup;
    // TODO: хм, то есть еси групп будет бульше чем цветов, то все сломается, давай вычислять цвет
    $templateDataArr['car_group'][$groupCounter]['color']    = "hsl({$color}, 100%, 50%)";
    $groupCounter++;
    $color += $colorStep;
}

//
print Template::build(file_get_contents(TEMPLATE_FILE_PATH), $templateDataArr);

/**
 * Возвращает даипозон Л.С., которому принадлежит автомобиль.
 * Пример:
 *     134 => '100-150'
 *     50  => '50-100'
 *
 * @param integer $__hp Лошадиные силы автомобиля.
 * 
 * @return string Название группы, которой принадлежит автомобиль.
 */
function getHpGroup(int $__hp)
{   
    # Окргляем количество лошадиных сил в меньшую сторону до числа кратного STEP
    $min = STEP * floor($__hp / STEP);
    $max = $min + STEP;

    # Возвращаем название диапозона лошадиных сил
    return $min.'-'.$max.' HP';
}
