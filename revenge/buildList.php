<?php

// Написать функцию buildList($__links, $__currentPage),
// которая генерирует массив для заполнения списка ссылок, который задан следующим шаблоном:

//     <style>
//     	li {color: #f00;}
//     	li a {color: #00f; text-decoration: underline;}
//     </style>
//     <ul>
//     <!-- item -->
//     <li>
//     	<!-- item.$is_active<>1 --><a href="<!-- .$url -->"><!-- item.$is_active_ends -->
//     		<!-- .$name -->
//     	<!-- item.$is_active<>1 --></a><!-- item.$is_active_ends -->
//     </li>
//     <!-- item_ends -->
//     </ul>

// Переменная is_active отмечает, что текущий адрес страницы равен $__currentPage.

// Массив $__links задан в следующем виде:

//     array (
//       'yandex.ru' => 'Яндекс',
//       'mail.ru' => 'Mail',
//     )

function buildList($__links, $__currentPage)
{
    $resArr = array();
    $c = 0;
    foreach ($__links as $url => $name) {
        $resArr['item'][$c]['name'] = $name;
        $resArr['item'][$c]['url'] = 'http://' . $url;
        if ($url == $__currentPage) {
            $resArr['item'][$c]['is_active'] = 1;
        } else {
            $resArr['item'][$c]['is_active'] = 0;
        }
        $c++;
    }

    return $resArr;
}