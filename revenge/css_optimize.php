<?php

// Реализовать функцию css_optimize($__code),
// на вход которой поступает массив $__code вида
// ['селектор' => ['свойство1', 'свойство2'], ...].

// Функция возвращает массив такого же вида,
// но с объединенными селекторами для одинаковых свойств, например:

// ['a' => ['color: red', 'font-weight: 400'],
//  'h1' => ['color: red', 'font-weight: 500']

//  необходимо преобразовать в:

//  ['a, h1' => ['color: red'],
//   'a' => ['font-weight: 400'],
//    'h1' => ['font-weight: 500']

// Порядок названий в объединенном селекторе выстраивается в соответствие
// с первоначальным видом, например, если в исходном тексте был порядок
// ['a' => ..., 'h2' => ..., 'h1' => ...]
// то объединенный селектор выглядит так: 'a, h2, h1'

// Для определенности, полученный массив отсортировать при помощи ksort()
// и подмассивы свойств при помощи sort().

function css_optimize($__code)
{
    $resArr = array();
    $code = $__code;
    foreach ($__code as $property_name => $property_arr) {
        foreach ($property_arr as $index => $property) {
            $res = array();
            $res[] = $property_name;
            $flag = false;
            foreach ($__code as $pn => $pa) {
                if (!$flag) {
                    if (
                        $pn == $property_name
                    ) {
                        $flag = true;
                    }
                    continue;
                }

                foreach ($pa as $i => $p) {
                    if ($property == $p) {
                        $res[] = $pn;
                    }
                }
            }
            if (count($res) > 1) {
                foreach ($res as $value) {
                    unset($code[$value][array_search($property, $code[$value])]);
                    unset($__code[$value][array_search($property, $__code[$value])]);
                }
                $code[implode(', ', $res)][] = $property;
            }
        }
    }

    $result = array();
    foreach ($code as $name => $value) {
        if (empty($value)) {
            continue;
        }
        sort($value);
        $result[$name] = $value;
    }

    ksort($result);

    return $result;
}





// TEST ARGUMENT:
// Array
// (
//   [a] => Array
//     (
//       [0] => text-decoration: none
//       [1] => color: #757575
//       [2] => font-weight: 400
//       [3] => line-height: 24px
//     )

//   [h1] => Array
//     (
//       [0] => color: red
//       [1] => font-weight: 500
//       [2] => line-height: 24px
//     )

//   [h2] => Array
//     (
//       [0] => color: red
//       [1] => font-weight: 400
//       [2] => line-height: 24px
//     )

// )
// TEST ANSWER
// Array
// (
//   [a] => Array
//     (
//       [0] => color: #757575
//       [1] => text-decoration: none
//     )

//   [a, h1, h2] => Array
//     (
//       [0] => line-height: 24px
//     )

//   [a, h2] => Array
//     (
//       [0] => font-weight: 400
//     )

//   [h1] => Array
//     (
//       [0] => font-weight: 500
//     )

//   [h1, h2] => Array
//     (
//       [0] => color: red
//     )

// )