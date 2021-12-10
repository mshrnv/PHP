<?php

require_once('Template.php');
define('STEP', 50);

$carsArr = array(
    array('manufactor' => 'BMW', 'model' => 'Smart', "hp" => 45),
    array('manufactor' => 'BMW', 'model' => 'X1', "hp" => 50),
    array('manufactor' => 'Mazda', 'model' => '6', "hp" => 55),
    array('manufactor' => 'Mazda', 'model' => '3', "hp" => 65),
    array('manufactor' => 'Hyundai', 'model' => 'i30', "hp" => 120),
    array('manufactor' => 'Lada', 'model' => 'Granta', "hp" => 170),
    array('manufactor' => 'Lada', 'model' => 'Granta Turbo', "hp" => 190),
);

$colorsArr = array('lightcoral', 'yellow', 'lightgreen', 'lightblue', 'purple');

$carGroupsArr = array();
foreach ($carsArr as $carArr) {
    $carGroupsArr[ getHpGroup($carArr['hp']) ][$carArr['manufactor']][] = $carArr;
}

//print_r($carGroupsArr);

$templateHtml = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
        <style>
            table{
                border-collapse: collapse;
            }
            td{
                border: 1px solid black;
                padding: 0px 5px;
            }
        </style>
    </head>
    <body>
        <table>
            <tr>
                <td><b>Manufactor</b></td>
                <td><b>Model</b></td>
                <td><b>HP</b></td>
            </tr>
            <!-- car_group -->
                <tr style="background-color:<!-- .$color -->; text-align:center;"><td colspan="3"><!-- .$hp_group --></td></tr>
                <!-- manufactor -->
                    <tr><td rowspan="<!-- .$rowspan -->" ><!-- .$manufactor--></td>
                        <!-- model[1] -->                         
                                <td><!-- .$model --></td>
                                <td><!-- .$hp --></td>
                            </tr>
                            <tr>
                        <!-- model_ends -->
                        <!-- model -->
                                <td><!-- .$model --></td>
                                <td><!-- .$hp --></td>
                            </tr>
                            <tr>
                        <!-- model_ends -->
                    </tr>
                <!-- manufactor_ends -->
            <!-- car_group_ends -->
        </table>
    </body>
    </html>
';
//print_r($carGroupsArr);
$groupCounter = 0;
foreach ($carGroupsArr as $hp_group => $carGroup) {
    $manufactorCounter = 0;
    foreach ($carGroup as $manufactor => $cars) {
        $templateDataArr['car_group'][$groupCounter]['manufactor'][$manufactorCounter]['model'] = $cars;
        $templateDataArr['car_group'][$groupCounter]['manufactor'][$manufactorCounter]['manufactor'] = $manufactor;
        $templateDataArr['car_group'][$groupCounter]['manufactor'][$manufactorCounter]['rowspan'] = count($cars);
        $manufactorCounter++;
    }
    $templateDataArr['car_group'][$groupCounter]['hp_group'] = $hp_group;
    $templateDataArr['car_group'][$groupCounter]['color']    = array_shift($colorsArr);
    $groupCounter++;
}

//print_r($templateDataArr);
print Template::build($templateHtml, $templateDataArr);

function getHpGroup(int $__hp)
{
    $min = STEP * floor($__hp / STEP);
    $max = $min + STEP;
    return $min.'-'.$max.' HP';
}