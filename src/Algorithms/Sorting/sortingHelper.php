<?php

function insertionSort(array $array): array
{
    for ($i = 1; $i < count($array); $i++) {
        $j = $i - 1;
        while ($j >= 0 && $array[$j] > $array[$j + 1]) {
            $tmp = $array[$j + 1];
            $array[$j + 1] = $array[$j];
            $array[$j] = $tmp;
            $j--;
        }
    }
    return $array;
}
