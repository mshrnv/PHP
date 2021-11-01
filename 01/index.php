<?php

//Заполнение массивов результатами работы функций fibonacci и fibonacciRecursive
for ($iterable = 1; $iterable <= 10; $iterable++) {
    $fibonacciElements[]          = fibonacci($iterable);
    $fibonacciRecursiveElements[] = fibonacciRecursive($iterable);
}

//Вывод массивов с членами последоватеьности
printArray($fibonacciElements);
print "<br>";
printArray($fibonacciRecursiveElements);

/**
 * Распечатывает элементы массива в строку через пробел.
 * 
 * @param array $__array Массив, элементы которого будут распечатаны.
 * 
 * @return void
 */
function printArray(array $__array)
{
    print implode(" ", $__array);
}

/**
 * Возвращает член последовательности Фибоначи с номером $__index
 * 
 * @param integer $__index Номер члена последовательности.
 * 
 * @return integer Член последовательности.
 */
function fibonacci(int $__index)
{  
    //Отрицательный или нулевой индекс
    if ($__index < 1) {
        return 0;
    }
    
    //Первые два члена последовательности Фибоначи
    if ($__index < 3) {
        return 1;
    }
    
    //Инициалзация двух первых членов последовательности
    $current  = 1;
    $previous = 1;
    
    //Вычисление $__index-ого члена
    for ($iterable = 3; $iterable <= $__index; $iterable++) {
        
        //Обновление двух крайних членов для вычисления следующего
        $temp     = $current + $previous;
        $previous = $current;
        $current  = $temp;
    }
    return $current;
}

/**
 * Возвращает член последовательности Фибоначи с номером $__index (рекурсивно)
 * 
 * @param integer $__index Номер члена последовательности.
 * 
 * @return integer Член последовательности.
 */
function fibonacciRecursive(int $__index)
{
    //Отрицательный или нулевой индекс
    if ($__index < 1) {
        return 0;
    }
    
    //Первые два члена последовательности
    if ($__index < 3) {
        return 1;
    }
    
    //Рекурсия: член последовательности является суммой двух предыдущих
    return fibonacciRecursive($__index - 1) + fibonacciRecursive($__index - 2);
}
