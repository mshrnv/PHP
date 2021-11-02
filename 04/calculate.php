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

if (isset($_POST)) {
    foreach (['number1', 'number2', 'operation', 'base', 'result'] as $variableName) {
        $$variableName = isset($_REQUEST[$variableName]) ? strval($_REQUEST[$variableName]) : false;
        print $variableName.' => '.$$variableName."<br>";
    }

    if (preg_match('/[^a-zA-Zа-яА-Я0-9]/', $number1) || preg_match('/[^a-zA-Zа-яА-Я0-9]/', $number2)) {
        print "FLAG";
    }
}

if ($base)
    $data['error'] = checkErrors($number1, $number2, $operation, $base, $result, $basesArr);

if ($data['error'] == '') {
    $data['result'] = calculate($number1, $number2, $result, $operation, $basesArr[$base]['alphabet']);
}



function calculate($__num1, $__num2, $__result, $__operation, $__alphabet){
    
    if ($__num1 == '' && $__result != '') {
        $__num1 = $__result;
    }

    if ($__num2 == '' && $__result != '') {
        $__num2 = $__num1;
        $__num1 = $__result;
    }
    
    $__num1 = toDec($__num1, $__alphabet);
    $__num2 = toDec($__num2, $__alphabet);
    var_dump($__num1);
    var_dump($__num2);

    switch ($__operation) {
        case '+':
            return fromDec($__num1 + $__num2, $__alphabet);
        case '-':
            return fromDec($__num1 - $__num2, $__alphabet);
        case '*':
            return fromDec($__num1 * $__num2, $__alphabet);
        case '/':
            return fromDec($__num1 / $__num2, $__alphabet);
        default:
            return -1;
    }

}


/**
 * Проверяет введенные данные на наличие ошибок
 * 
 * @param string  $__num1      Первое число.
 * @param string  $__num2      Второе число.
 * @param string  $__operation Выбранная операция.
 * @param string  $__base      Выбранная СС.
 * @param string  $__result    Результат выполнения предыдущей операции.
 * @param array   $__basesArr  Массив с СС.
 * 
 * @return string Сообщение об ошибке.
 */
function checkErrors(string $__num1, string $__num2, string $__operation, string $__base, string $__result, array $__basesArr){

    if (!$__num1 && !$__num2) {
        return 'Поля не заполнены';
    }

    if ($__num1 == '' && $__result == ''){
        return 'Первое поле не заполнено';
    }

    if ($__num2 == '' && $__result == ''){
        return 'Второе поле не заполнено';
    }

    if (!$__operation) {
        return 'Не выбрана операция';
    }
    
    if (!$__base) {
        return 'Не выбрана система счисления';
    }

    $alphabet = $__basesArr[$__base]['alphabet'];

    if (!checkInputData($__num1, $alphabet)) {
        return 'Первое число не соответствует алфавиту СС';
    }

    if (!checkInputData($__num2, $alphabet)) {
        return 'Второе число не соответствует алфавиту СС';
    }

    if (toDec($__num2, $alphabet) == 0 && $__operation == '/') {
        return 'Деление на 0';
    }

    $decNum1 = toDec($__num1, $alphabet);
    $decNum2 = toDec($__num2, $alphabet);

    if($decNum1 < 0){
        return 'Первое число - отрицательное';
    }

    if($decNum2 < 0){
        return 'Второе число - отрицательное';
    }

    if ($decNum1 < $decNum2 && $__operation == '-') {
        return 'Отрицательные числа не поддерживаются';
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

/**
 * Переводит число в десятичную СС
 * 
 * @param string $__num          Число для перевода в 10-ую СС.
 * @param string $__baseAlphabet Алфавит исходной СС.
 * 
 * @return int Число в десятичной СС.
 */
function toDec(string $__num, string $__baseAlphabet){
    
    $res = '';

    for ($i = 0; $i < mb_strlen($__num); $i++) {
        $res .= strpos($__baseAlphabet, $__num[$i]);
    }

    return base_convert($res, mb_strlen($__baseAlphabet), 10);
}

/**
 * Переводит число из десятичной СС в заданную
 * 
 * @param string $__num          Число для перевода из 10-ой СС.
 * @param string $__baseAlphabet Алфавит заданной СС.
 * 
 * @return string Число в десятичной СС.
 */
function fromDec(string $__num, string $__baseAlphabet){
    
    $converted = base_convert($__num, 10, mb_strlen($__baseAlphabet));
    $res = '';

    for ($i = 0; $i < mb_strlen($converted); $i++) { 
        $res .= $__baseAlphabet[$converted[$i]];
    }

    return $res;
}

/**
 * Проверяет введенное поле на соответствие алфавиту
 * 
 * @param string $__inputData Введенное поле.
 * @param string $__alphabet  Алфавит заданной СС.
 * 
 * @return int 1 - соответствует
 *             0 - не соответсвует
 */
function checkInputData(string $__inputData, string $__alphabet) {
    
    for ($i = 0; $i < mb_strlen($__inputData); $i++) { 
        if(strpos($__alphabet, $__inputData[$i]) === false){
            return false;
        }
    }

    return true;
}
