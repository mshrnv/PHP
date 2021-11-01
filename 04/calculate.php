<?php

$basesArr = array(
    'bin' => [
        'name'     => 'Binary',
        'alphabet' => '01'
    ],
    'oct' => [
        'name'     => 'Octal',
        'alphabet' => '01234567'
    ],
    'dec' => [
        'name'     => 'Decimal',
        'alphabet' => '0123456789'
    ],
    'hex' => [
        'name'     => 'Hexadecimal',
        'alphabet' => '0123456789abcdef'
    ]
);

$data = array(
    'result' => '',
    'error'  => '',
);

if (isset($_REQUEST)) {
    foreach (['operation', 'base'] as $variableName) {
        $$variableName = isset($_REQUEST[$variableName]) ? strval($_REQUEST[$variableName]) : false;
        print $variableName.' => '.$$variableName."<br>";
    }

    foreach (['number1', 'number2'] as $variableName) {
        $$variableName = isset($_REQUEST[$variableName]) ? strval($_REQUEST[$variableName]) : false;
        print $variableName.' => '.$$variableName."<br>";
    }

    if (preg_match('/[^a-zA-Zа-яА-Я0-9]/', $number1) || preg_match('/[^a-zA-Zа-яА-Я0-9]/', $number2)) {
        print "FLAG";
    }
}

switch ($operation) {
    case '+':
        $res = $number1 + $number2;
        break;
    case '-':
        $res = $number1 - $number2;
        break;
    case '*':
        $res = $number1 * $number2;
        break;
    case '/':
        $res = $number1 / $number2;
        break;
    default:
        $res = 'error';
        break;
    }

$data['error'] = checkErrors($number1, $number2, $operation, $base);

function checkErrors($__num1, $__num2, $__operation, $__base){

    if (!$__num1 && !$__num2) {
        return 'Поля не заполнены';
    }

    if (!$__operation) {
        return 'Не выбрана операция';
    }
    
    if(!$__base){
        return 'Не выбрана система счисления';
    }

    return '';
}

/**
 * Возвращает список <select> из массива $__basesArr
 * 
 * @param array  $__basesArr Массив систем счисления.
 * @param string $__selected Выбранная система счисления.
 * 
 * @return string HTML код тегов select с учетом выбранной СС.
 */
function printSelects(array $__basesArr, string $__selected){
    
    $html = '';
    foreach ($__basesArr as $base => $value) {
        if($base == $__selected){
            $html .= "<option value='{$base}' selected>{$value['name']}</option>";
        } else {
            $html .= "<option value='{$base}'>{$value['name']}</option>";
        }
    }

    return $html;
}
 
function toDec(string $__num, string $__baseAlphabet){
    
    $res = '';

    for ($i = 0; $i < mb_strlen($__num); $i++) {
        $res .= strpos($__baseAlphabet, $__num[$i]);
    }

    return base_convert($res, mb_strlen($__baseAlphabet), 10);
}

function fromDec(string $__num, string $__baseAlphabet){
    
    $converted = base_convert($__num, 10, mb_strlen($__baseAlphabet));
    $res = '';

    for ($i = 0; $i < mb_strlen($converted); $i++) { 
        $res .= $__baseAlphabet[$converted[$i]];
    }

    return $res;
}

function checkInputData(string $__inputData, string $__alphabet) {
    return preg_match("[$__alphabet]", $__inputData);
}

print checkInputData('df', 'asdfm');