<?php

// PCRE. Написать функцию delete_span_tags($__code),
// которая удаляет теги span(вместе с содержимым), вложенные в теги div.
// Возвращает полученный код.

function delete_span_tags($__code)
{
    return preg_replace_callback(
        '/(<div.*?>.*?)<span.*?>.*?<\/span>(.*?<\/div>)/ui',
        function ($matches) {
            return $matches[1] . $matches[2];
        },
        $__code
    );
}

$text = '<h1>Привет!</h1> 
                                    <div class="hidden">Это <span id="sd34" style="text-align:justify;">простейший пример</span> HTML-документа.</div> 
                                    <span>Этот *.html-файл</span> <div>может быть</div> одновременно<span> открыт
                                     <span>и в Notepad, </span>и в Netscape. 
                                    Сохранив изменения в Notepad, просто нажмите кнопку
                                     Reload ("перезагрузить") в Netscape, чтобы увидеть
                                     эти <div>изменения реализованными в HTML-документе.</div> ';

print(delete_span_tags($text));
