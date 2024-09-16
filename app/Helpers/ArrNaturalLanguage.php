<?php

/**
 * Join a string with a natural language conjunction at the end.
 */
function arr_natural_language(array $list, $conjunction = 'and')
{
    $last = array_pop($list);

    if ($list) {
        return implode(', ', $list).' '.$conjunction.' '.$last;
    }

    return $last;
}
