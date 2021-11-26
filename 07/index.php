<?php

# Массив ссылок для теста
$urlsArr = array(
    "http://http.ru/folder/subfolder/../././script.php?var1=val1&var2=val2",
    "https://http.google.com/folder//././?var1=val1&var2=val2",
    "ftp://mail.ru/?hello=world&url=https://http.google.com/folder//././?var1=val1&var2=val2",
    "mail.ru/?hello=world&url=https://http.google.com/folder//././?var1=val1&var2=val2",
    "?mail=ru",
    "domain2.zone:8080/folder/subfolder/../././../asdss/.././//////../myfolder/script.php?var1=val1&var2=val2",
    "http://dom.dom.domain2.com:8080/folder/subfolder/./myfolder/script.php?var1=val1&var2=val2?var1=val1&var2=val2",
);

# Поочередный вывод результата работы функции
foreach ($urlsArr as $url) {
    echo $url."\n";
    print_r(myUrlPcreParse($url));
    echo "\n\n";
}

/**
 * Разбивает URL на составные части
 *
 * @param string $__url URL-адрес.
 * 
 * @return array Массив составных частей URL.
 */
function myUrlPcreParse(string $__url)
{

    //
    $resultArr = array(
        'protocol'        => false,
        'domain'          => false,
        'zone'            => false,
        '_2_level_domain' => false,
        'port'            => false,
        'raw_folder'      => false,
        'folder'          => false,
        'script_path'     => false,
        'script_name'     => false,
        'is_php'          => false,
        'parameters'      => array(),
        'is_error'        => false
    );

    # Регулярное выражение
    $regExp = '/
        (?(?=^[\w]*(?=:\/\/))             #Если есть протокол
        (?:(?<protocol>^[\w]*)(?::\/\/)   #Протокол
        (?<domain>                        #Домен
        (?<_2_level_domain>\w*\.)*        #Домен вторго уровня
        (?<zone>\w+)?)                    #Зона
        (?:(?(?=:):                       #Если еть порт
        (?:(?<port>\w*?)(?:\/))|\/))))    #Порт
        (?<raw_folder>[\w\/\.:]*\/)*      #Относительный путь к файлу
        (?<script_name>[\w\.]+\.+\w+)*\?  #Расширение скрипта
        ?(?<parameters>\S+)*              #Параметры    
        /xuis';
    
    # Применяем регулярное выражение к URL, оставляем только строковые ключи массива
    preg_match($regExp, $__url, $matches, PREG_UNMATCHED_AS_NULL);
    $matches = array_filter($matches, "is_string", ARRAY_FILTER_USE_KEY);

    # Убираем из массива ненайденные значения и сливаем с шаблонным
    $matches   = array_diff($matches, array(null));
    $resultArr = array_merge($resultArr, $matches);

    # Скрипт по умолчанию: index.php
    if ($resultArr['parameters'] && !$resultArr['script_name']) {
        $resultArr['script_name'] = 'index.php';
    }

    # Порт по умолчанию: 80
    if ($resultArr['protocol'] && !$resultArr['port']) {
        $resultArr['port'] = '80';
    }

    # Вычисление folder, script_path, флага is_php
    $resultArr['_2_level_domain'] .= $resultArr['zone'];
    $resultArr['folder']           = pathParse($resultArr['raw_folder']);
    $resultArr['script_path']      = $resultArr['folder'].'/'.$resultArr['script_name'];
    $resultArr['is_php']           = preg_match('/\b\w+\.php\b/uis', $resultArr['script_name']);

    # Разбиваем параметры на пары и записываем в итоговый массив
    $parametersArr           = preg_split('/&/uis', $resultArr['parameters']);
    $resultArr['parameters'] = array();
    foreach ($parametersArr as $pair) {
        list($key, $resultArr['parameters']["$key"]) = preg_split('/=/uis', $pair, 2);
    }

    //
    return $resultArr;
}

/**
 * Осуществляет вычисление действительного пути к файлу
 * 
 * @param string $__rawPath Введеный путь к файлу.
 * 
 * @return string Действительный путь к файлу.
 */
function pathParse(string $__rawPath)
{
    $__rawPath = explode('/', $__rawPath);

    # Обработка содержимого между '/' в введеном пути
    foreach ($__rawPath as $folder) {
        if ($folder == "" || $folder == ".") {
            continue;
        }
        else if ($folder == "..") {
            array_pop($pathArr);
        }
        else {
            $pathArr[] = $folder;
        }
    }

    # Возвращаемый массив
    return isset($pathArr) ? implode('/', $pathArr) : '';
}
