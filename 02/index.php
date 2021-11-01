<?php

//Двумерный массив слов, подлежащий выравниванию
$wordsArraysArr = array(
    array("word1.1", "bigword1.2", "moreword1.3", "biggerword1.4"),
    array("word2.1"),
    array("word3.1", "bigword3.2", "moreword3.3"),
    array("word4.1", "bigword4.2", "moreword4.3", "biggerword4.4", "thebiggestword4.5", "thebiggestwordintheworld4.6"),
    array("word5.1", "bigword5.2", "moreword5.3", "biggerword5.4"),
    array("word6.1", "bigword6.2"),
    array("word7.1", "bigword7.2", "moreword7.3", "biggerword7.4", "thebiggestword7.5"),
);

//Длина наибольшего подмассива
$maxArrayLength = count(max($wordsArraysArr)); 

//Дополнение подмассивов пустыми стркоами до размера самого большого подмассива
foreach ($wordsArraysArr as $key => $wordArray) {
    $wordsArraysArr[$key] = array_pad($wordArray, $maxArrayLength, "");
}

//Поочередное дополнение слов пробелами
foreach ($wordsArraysArr as $arrayKey => $wordArray) {
    $strPad           = ($arrayKey % 2) ? STR_PAD_LEFT : STR_PAD_RIGHT;
    $maxLengthInArray = max(array_map('mb_strlen', $wordArray));
    foreach ($wordArray as $wordKey => $word) {
        $wordsArraysArr[$arrayKey][$wordKey] = str_pad($word, $maxLengthInArray, " ", $strPad);
    }
}

//Транспонирование массива: строки становятся столбцами, стобцы - строками
$wordsArraysArr = arrayTranspose($wordsArraysArr);

//Объединение слов во всех подмассивах в строку с разделителем в два пробела
foreach ($wordsArraysArr as $key => $wordsArray) {
    $wordsArraysArr[$key] = implode("  ", $wordsArray);
}

//Объединение всех подмассивов в строку разделяя переносом на новую строку и вывод
print "<!DOCTYPE html><html><body><pre>".implode("\n", $wordsArraysArr)."</pre></body></html>";

/**
 * Траспонирование массива с вложенными массивами одинаковой длины
 * 
 * @param array $__array Массив для траспонирования.
 * 
 * @return array Транспонированный массив
 */
function arrayTranspose(array $__array)
{
    foreach ($__array[0] as $index => $val) {
        
        // Изменения данных по которым пробегает цикл - нет.
        // Массив из которого читаем - "$__array", в который записываем - "$array"
        $array[$index] = array_column($__array, $index);
        $index++;
    }
    
    // Возвращаем транспонированный массив
    return $array;
}
