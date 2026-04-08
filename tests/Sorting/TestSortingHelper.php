<?php

declare(strict_types=1);

namespace Sorting;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class TestSortingHelper extends TestCase
{
    #[DataProvider('sortingDataProvider')]
    public function testInsertionSort(array $inputArray, array $expectedArray): void
    {
        $this->assertArraysAreEqual(insertionSort($inputArray), $expectedArray);
    }

    #[DataProvider('sortingDataProvider')]
    public function testMergeSort(array $inputArray, array $expectedArray): void
    {
        mergeSort($inputArray, 0, count($inputArray) - 1);
        $this->assertArraysAreEqual($inputArray, $expectedArray);
    }

    public static function sortingDataProvider(): array
    {
        return [
            [[], []],
            [[99, 21, 0, 0, 451, 2, 6, 12], [0, 0, 2, 6, 12, 21, 99, 451]],
            [[9, 8, 7, 6, 5, 4, 3, 2, 1, 0], [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]],
            [[0, 12, 33, 2, 5], [0, 2, 5, 12, 33]],
            [[1, 1, 1, 1], [1, 1, 1, 1]]
        ];
    }
}
