<?php

$urlsArr = array(
    "http://http.ru/folder/subfolder/../././script.php?var1=val1&var2=val2",
    "https://http.google.com/folder//././?var1=val1&var2=val2",
    "ftp://mail.ru/?hello=world&url=https://http.google.com/folder//././?var1=val1&var2=val2",
    "mail.ru/?hello=world&url=https://http.google.com/folder//././?var1=val1&var2=val2",
    "?mail=ru",
    "domain2.zone:8080/folder/subfolder/../././../asdss/.././//////../myfolder/script.php?var1=val1&var2=val2",
    "http://dom.dom.domain2.com:8080/folder/subfolder/./myfolder/script.php?var1=val1&var2=val2?var1=val1&var2=val2",
);

foreach ($urlsArr as $url) {
    echo $url."\n";
    var_dump(myUrlPcreParse($url));
    echo "\n\n";
}

function myUrlPcreParse(string $__url)
{

    //
    $resultArr = array(
        'protocol'       => false,
        'domain'         => false,
        'zone'           => false,
        '2_level_domain' => false,
        'port'           => false,
        'raw_folder'     => false,
        'folder'         => false,
        'script_path'    => false,
        'script_name'    => false,
        'is_php'         => false,
        'parameters'     => array(),
        'is_error'       => false
    );

    # Регулярное выражение
    $regexp = '/
        (?(?=^[\w]*(?=:\/\/))             #Если есть протокол
        (?:(?<protocol>^[\w]*)(?::\/\/)   #Протокол
        (?<domain>\w*\.*                        #Домен
        (?<two_level_domain>\w*\.       #Домен вторго уровня
        (?<zone>\w+))*?)                    #Зона
        (?:(?(?=:):                       #Если еть порт
        (?:(?<port>\w*?)(?:\/))|\/))))    #Порт
        (?<raw_folder>[\w\/\.:]*\/)*      #Относительный путь к файлу
        (?<script_name>[\w\.]+\.+         #Путь к файлу
        (?<extension>\w+))*\?             #Расширение скрипта
        ?(?<parameters>\S+)*              #Параметры    
        /xius';
    
    # Применяем регулярное выражение к URL и оставляем только строковые ключи массива
    preg_match($regexp, $__url, $matches, PREG_UNMATCHED_AS_NULL);
    $matches = array_filter($matches, "is_string", ARRAY_FILTER_USE_KEY);
    $matches = array_diff($matches, array(null));

    # 
    // if ($parsedUrlArr['script_name'] == '') {
    //     $parsedUrlArr['script_name'] = 'index.php';
    //     $parsedUrlArr['extension']   = 'php';
    // }

    // $extension = $resultArr['extension'];
    // unset($resultArr['extension']);


    return $matches;
}

/**
 * Осуществляет вычисление действительного пути к файлу
 * 
 * @param string $__rawPath Введеный путь к файлу.
 * 
 * @return array Массив с подряд идущими директориями (действительный путь к файлу).
 */
function pathParse(string $__rawPath)
{
    $__rawPath = explode('/', $__rawPath);

    //Обработка содержимого между '/' в введеном пути
    foreach ($__rawPath as $folder) {
        if ($folder == "" || $folder == ".") {
            continue;
        } else if ($folder == "..") {
            array_pop($pathArr);
        } else {
            $pathArr[] = $folder;
        }
    }

    //Возвращаемый массив
    return isset($pathArr) ? $pathArr : array();
}