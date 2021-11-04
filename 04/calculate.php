<?php

//Массив СС
$basesArr = array(
    'bin' => array(
        'name'     => 'Binary',
        'alphabet' => '01'
    ),
    'oct' => array(
        'name'     => 'Octal',
        'alphabet' => '01234567'
    ),
    'dec' => array(
        'name'     => 'Decimal',
        'alphabet' => '0123456789'
    ),
    'hex' => array(
        'name'     => 'Hexadecimal',
        'alphabet' => '0123456789abcdef'
    )
);

//Итоговый массив
$dataArr = array(
    'result' => '',
    'error'  => '',
);

//Проверка POST запроса
if (isset($_POST)) {
    
    //Инициализация переменных
    foreach (array('number1', 'number2', 'operation', 'base', 'result') as $variableName) {
        $$variableName = isset($_POST[$variableName]) ? strval($_POST[$variableName]) : false;
    }
    
    //dec - по умолчанию, если не выбрана
    $base = $base ? $base : 'dec';
    
    //Проверка на наличие ошибок
    $dataArr['error'] = checkErrors($number1, $number2, $operation, $base, $result, $basesArr);
    
    //Если нет ошибок - вычисление результата
    if ($dataArr['error'] == '') {
        $dataArr['result'] = calculate($number1, $number2, $result, $operation, $basesArr[$base]['alphabet']);
    }
}

/**
 * Вычисление результата
 * 
 * @param string $__num1      Первое число.
 * @param string $__num2      Второе число.
 * @param string $__result    Результат предыдущей операции.
 * @param string $__operation Выбранная операция.
 * @param string $__alphabet  Алфавит выбранной СС.
 * 
 * @return string Результат.
 */
function calculate(string $__num1, string $__num2, string $__result, string $__operation, string $__alphabet)
{
    
    //Если нет первого поля - то в него помещается результат
    if ($__num1 == '' && $__result != '') {
        $__num1 = $__result;
    }
    
    //Если нет второго поля, то первое во второе, результат - в первое(согласно ТЗ)
    if ($__num2 == '' && $__result != '') {
        $__num2 = $__num1;
        $__num1 = $__result;
    }
    
    //Перевод введенных чисел в 10-ую СС
    $__num1 = toDec($__num1, $__alphabet);
    $__num2 = toDec($__num2, $__alphabet);
    
    //
    return getResult($__num1, $__num2, $__operation, $__alphabet);
}

/**
 * Вычисление результата
 * 
 * @param string $__num1      Первое число.
 * @param string $__num2      Второе число.
 * @param string $__operation Операция.
 * @param string $__alphabet  Алфавит СС.
 * 
 * @return string Результат применения операции.
 */
function getResult(string $__num1, string $__num2, string $__operation, string $__alphabet)
{
    
    //Выбор соответствующей операции
    switch ($__operation) {
        case '+':
            return fromDec($__num1 + $__num2, $__alphabet);
        case '-':
            return fromDec($__num1 - $__num2, $__alphabet);
        case '*':
            return fromDec($__num1 * $__num2, $__alphabet);
        case '/':
            return fromDec(round($__num1 / $__num2), $__alphabet);
            
        //Неверная операция
        default:
            return -1;
    }
}

/**
 * Проверяет введенные данные на наличие ошибок
 * 
 * @param string $__num1      Первое число.
 * @param string $__num2      Второе число.
 * @param string $__operation Выбранная операция.
 * @param string $__base      Выбранная СС.
 * @param string $__result    Результат выполнения предыдущей операции.
 * @param array  $__basesArr  Массив с СС.
 * 
 * @return string Сообщение об ошибке.
 */
function checkErrors(string $__num1, string $__num2, string $__operation, string $__base, string $__result, array $__basesArr)
{

    //Поля пустые
    if (!$__num1 && !$__num2) {
        return 'Поля не заполнены';
    }
    
    //
    if ($__num1 == '' && $__result == '') {
        return 'Первое поле не заполнено';
    }

    //
    if ($__num2 == '' && $__result == '') {
        return 'Второе поле не заполнено';
    }

    //
    if (!$__operation) {
        return 'Не выбрана операция';
    }
    
    //
    if (!$__base) {
        return 'Не выбрана система счисления';
    }

    //Вытаскиваем алфавит выбранной СС
    $alphabet = $__basesArr[$__base]['alphabet'];

    //Проверка на соответствие алфавиту
    if (!checkInputData($__num1, $alphabet)) {
        return 'Первое число не соответствует алфавиту СС';
    }

    //
    if (!checkInputData($__num2, $alphabet)) {
        return 'Второе число не соответствует алфавиту СС';
    }

    //Проверка деления на 0
    if (toDec($__num2, $alphabet) == 0 && $__operation == '/') {
        return 'Деление на 0';
    }

    //Перевод чисел в 10-ую СС
    $decNum1 = toDec($__num1, $alphabet);
    $decNum2 = toDec($__num2, $alphabet);

    //Проверка на отрицательные введенные числа
    if ($decNum1 < 0) {
        return 'Первое число - отрицательное';
    }

    //
    if ($decNum2 < 0) {
        return 'Второе число - отрицательное';
    }

    //Если после вычитания получится отрицательное число - тоже ошибка
    if ($decNum1 < $decNum2 && $__operation == '-') {
        return 'Отрицательные числа не поддерживаются';
    }

    //Ошибок нет
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
function printSelects(array $__basesArr, string $__selected)
{
    
    //Перебор массива всех СС
    $html = '';
    foreach ($__basesArr as $base => $value) {
        
        //Атрибут selected для выбранной СС
        if ($base == $__selected) {
            $html .= "<option value='{$base}' selected>{$value['name']}</option>";
        }
        else {
            $html .= "<option value='{$base}'>{$value['name']}</option>";
        }
    }

    //HTML код
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
function toDec(string $__num, string $__baseAlphabet)
{

    //Перебор символов введенного числа
    $res       = '';
    $numLength = mb_strlen($__num);
    for ($i = 0; $i < $numLength; $i++) {
        $res .= strpos($__baseAlphabet, $__num[$i]);
    }

    //Переведенное в 10 СС число
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
function fromDec(string $__num, string $__baseAlphabet)
{

    //Перебор символов числа
    $converted = base_convert($__num, 10, mb_strlen($__baseAlphabet));
    $res       = '';
    $numLength = mb_strlen($converted);
    for ($i = 0; $i < $numLength; $i++) { 
        $res .= $__baseAlphabet[$converted[$i]];
    }

    //Переведенное в заданную СС число
    return $res;
}

/**
 * Проверяет введенное поле на соответствие алфавиту
 * 
 * @param string $__inputData Введенное поле.
 * @param string $__alphabet  Алфавит заданной СС.
 * 
 * @return bool Соответствует или нет.
 */
function checkInputData(string $__inputData, string $__alphabet)
{
    
    //Проверка каждого символа: есть ли оно в заданном алфавите
    $dataLength = mb_strlen($__inputData);
    for ($i = 0; $i < $dataLength; $i++) { 
        if (strpos($__alphabet, $__inputData[$i]) === false) {
            return false;
        }
    }

    //Все символы удовлетворяют алфавиту
    return true;
}
