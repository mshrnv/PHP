<?php

function important_words($__text)
{
    preg_match_all(
        "/'\b([\w (),]+)\b'/uis",
        $__text,
        $array
    );

    return $array[1];
}
