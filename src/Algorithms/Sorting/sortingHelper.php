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

function mergeSort(array &$array, int $start, int $end): void
{
    $merge = function (array &$array, int $start, int $middle, int $end) {
        $L = array_slice($array, $start, $middle - $start + 1);
        $R = array_slice($array, $middle + 1, $end - $middle);

        $i = 0;
        $j = 0;
        $k = $start;

        while ($i < count($L) && $j < count($R)) {
            if ($L[$i] <= $R[$j]) {
                $array[$k] = $L[$i];
                $i++;
            } else {
                $array[$k] = $R[$j];
                $j++;
            }
            $k++;
        }

        while ($i < count($L)) {
            $array[$k] = $L[$i];
            $i++;
            $k++;
        }
        while ($j < count($R)) {
            $array[$k] = $R[$j];
            $j++;
            $k++;
        }
    };

    if ($end - $start + 1 <= 1) {
        return;
    }

    $middle = intdiv($start + $end, 2);

    mergeSort($array, $start, $middle);
    mergeSort($array, $middle + 1, $end);

    $merge($array, $start, $middle, $end);
}
