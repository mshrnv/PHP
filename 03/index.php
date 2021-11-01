<?php

//Массив с ссылками для тестирования
$linksArr = array(
    'http://http.ru/folder/subfolder/../././script.php?var1=val1&var2=val2',
    'https://http.google.com/folder//././?var1=val1&var2=val2',
    'ftp://mail.ru/?hello=world&url=https://http.google.com/folder//././?var1=val1&var2=val2',
    'mail.ru/?hello=world&url=https://http.google.com/folder//././?var1=val1&var2=val2',
    'index.html?mail=ru',
    'domain2.zone:8080/folder/subfolder/../././../asdss/.././//////../myfolder/script.php?var1=val1&var2=val2',
    'http://dom.dom.domain2.com:8080/folder/subfolder/./myfolder/script.php?var1=val1&var2=val2?var1=val1&var2=val2',
);

//Вывод результата функции my_url_parse для каждой ссылки
foreach ($linksArr as $link) {
	$res = myUrlParse($link);
	echo $link."\n";
	print_r($res);
	echo "\n\n\n";
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
        }
        else if ($folder == "..") {
            array_pop($pathArr);
        }
        else {
            $pathArr[] = $folder;
        }
    }
	
    //Возвращаемый массив
    return isset($pathArr) ? $pathArr : array();
}

/**
 * Осуществляет разбор URL-адреса
 * 
 * @param string $__url URL-адрес.
 * 
 * @return array Составные части URL-адреса.
 */
function myUrlParse(string $__url)
{
    
    //
    $parsedUrlArr = array(
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

    //Делим URL по первому знаку вопроса => $urlNoParams и $parameters
    list($urlNoParams, $parameters) = explode('?', $__url, 2);

    //Отделяем протокол по '://'
    $parsedUrlArr = protocolDefinition($parsedUrlArr, $urlNoParams);

    //Содержимое после последнего '/' - потенциально является скриптом
    $fullPathArr            = explode('/', $parsedUrlArr['domain']);
    $parsedUrlArr['domain'] = false;
    $potentialScript        = array_pop($fullPathArr);

    //Проверка: является ли потенциальный скрипт таковым или нет
    $parsedUrlArr = checkPotentialScript($potentialScript, $parsedUrlArr);
    
    //Если функция вернула script_name => index.php, a $potentialScript таковым не является
    //То значит $potentialScript - является частью пути => вернем обратно в массив с путем
    if ($parsedUrlArr['script_name'] == 'index.php' && $potentialScript != 'index.php') {
        $fullPathArr[] = $potentialScript;
    }
    

    //
    if ($fullPathArr) {
        
        //Если в URL есть протокол, то первый элемент массива - это полное доменное имя
        if ($parsedUrlArr['protocol']) {
            $parsedUrlArr['domain']     = array_shift($fullPathArr);
            $parsedUrlArr['raw_folder'] = implode('/', $fullPathArr);
        }
        
        //Если в URL протокола нет, то все содержимое массива - относительный путь к файлу
        else {
            $parsedUrlArr['domain']     = false;
            $parsedUrlArr['raw_folder'] = implode('/', $fullPathArr);
        }
    }

    //Вычисление дейстивтельного пути к файлу
    if ($parsedUrlArr['raw_folder']) {
        $parsedUrlArr['folder'] = implode('/', pathParse($parsedUrlArr['raw_folder'])).'/';
    }
    
    //Вычисление port, zone, 2_level_domain и is_error
    $parsedUrlArr = domainPartsDefinition($parsedUrlArr);
    
    // ScriptPath = Folder(if exist) + ScriptName
    $parsedUrlArr['script_path'] = $parsedUrlArr['folder'].$parsedUrlArr['script_name'];
    
    //Определение флага is_php
    $parsedUrlArr['is_php'] = strpos($parsedUrlArr['script_name'], '.php') ? true : false;
    
    //Разбиение строки параметров на массив: Название параметра => Значение
    if ($parameters) {
        $parameters = explode('&', $parameters);
        foreach ($parameters as $parametr) {
            list($param, $parsedUrlArr["parameters"][$param]) = explode('=', $parametr, 2);
        }
    }
    
    //Результат выполнения функции
    return $parsedUrlArr;
}

/**
 * Определяет на основе полного доменного имени port, zone, 2_level_domain и флаг is_error
 * 
 * @param array $__parsedUrlArr Массив с составными частями URL-адреса.
 * 
 * @return array Массив, дополненный полями port, zone, 2_level_domain, is_error при наличии домена.
 */
function domainPartsDefinition(array $__parsedUrlArr)
{
    
    //В случае наличия протокола и домена, соответственно
    if ($__parsedUrlArr['domain']) {

        //Определение порта (ели существует)
        $domainNameArr            = explode(':', $__parsedUrlArr['domain'], 2);
        $__parsedUrlArr['domain'] = $domainNameArr[0];
        $__parsedUrlArr['port']   = (count($domainNameArr) == 1) ? 80 : $domainNameArr[1];

        //Определение флага is_error, zone, 2_level_domain
        $domainsArr                       = explode('.', $domainNameArr[0]);
        $__parsedUrlArr['is_error']       = (count($domainsArr) > 5) ? true : false;
        $__parsedUrlArr['zone']           = array_pop($domainsArr);
        $__parsedUrlArr['2_level_domain'] = array_pop($domainsArr).'.'.$__parsedUrlArr['zone'];
    }
    
    //Преобразованный массив
    return $__parsedUrlArr;
}

/**
 * Заносит в поле script_name массива $__parsedUrlArr значение $__potentialScript
 * Если он таковым является, иначе - index.php
 * 
 * @param string $__potentialScript Потенциальный скрипт.
 * @param array  $__parsedUrlArr    Массив с составными частями URL-адреса.
 * 
 * @return array Массив, дополненный полем script_name.
 */
function checkPotentialScript(string $__potentialScript, array $__parsedUrlArr)
{
    if (mb_strlen($__potentialScript) > 2 && strpos($__potentialScript, '.') !== false) {
        $__parsedUrlArr['script_name'] = $__potentialScript;
    }
    else {
        $__parsedUrlArr['script_name'] = 'index.php';
    }
    
    //Преобразованный массив
    return $__parsedUrlArr;
}

/**
 * Разбивает часть URL-адреса без параметров по '://'
 * И делает соответствующие записи в полях protocol и domain массива $__parsedUrlArr
 * 
 * @param array  $__parsedUrlArr Массив с составными частями URL-адреса.
 * @param string $__urlNoParams  URL-адрес без параметров.
 * 
 * @return array Массив, дополненный полями protocol и domain.
 */
function protocolDefinition(array $__parsedUrlArr, string $__urlNoParams)
{
    $__urlNoParams = explode('://', $__urlNoParams, 2);
    
    //Проверка на наличие протокола в $__urlNoParam
    if (count($__urlNoParams) === 1) {
        $__parsedUrlArr['protocol'] = false;
        $__parsedUrlArr['domain']   = $__urlNoParams[0];
    }
    else {
        list($__parsedUrlArr['protocol'], $__parsedUrlArr['domain']) = $__urlNoParams;
    }
        
    //Преобразованный массив
    return $__parsedUrlArr;
}
