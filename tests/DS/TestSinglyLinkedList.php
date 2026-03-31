<?php

declare(strict_types=1);

namespace DS;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use src\DS\SinglyLinkedList\LinkedList;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNull;

class TestSinglyLinkedList extends TestCase
{
    public function testListCreation(): void
    {
        $list = new LinkedList();
        assertNull($list->head);
    }

    #[DataProvider('pushingDataProvider')]
    public function testPushingInTheEnd(array $valuesToPush): void
    {
        $list = new LinkedList();
        foreach ($valuesToPush as $value) {
            $list->push($value);
        }

        $currentNode = $list->head;
        foreach ($valuesToPush as $value) {
            assertEquals($value, $currentNode->value);
            $currentNode = $currentNode->next;
        }
    }

    #[DataProvider('gettingDataProvider')]
    public function testGettingValue(array $values, array $indexes): void
    {
        $list = new LinkedList();
        foreach ($values as $value) {
            $list->push($value);
        }

        foreach ($indexes as $index) {
            assertEquals($values[$index], $list->get($index));
        }
    }

    public function testGettingValueOutOfBounds(): void
    {
        $list = new LinkedList();
        $valuesToPush = [123, 1, 22];
        foreach ($valuesToPush as $value) {
            $list->push($value);
        }
        assertEquals(-1, $list->get(22));
        assertEquals(-1, $list->get(12));
        assertEquals(-1, $list->get(100));
    }

    #[DataProvider('insertingInMiddleDataProvider')]
    public function testInsertingInMiddle(
        array $valuesToPush,
        int   $valueToInsert,
        int   $targetIndex,
    ): void {
        $list = new LinkedList();
        foreach ($valuesToPush as $value) {
            $list->push($value);
        }
        $oldValueOfIndex = $list->get($targetIndex);
        $list->insert($targetIndex, $valueToInsert);
        $newValue = $list->get($targetIndex);
        assertEquals($valueToInsert, $newValue);
        assertEquals($oldValueOfIndex, $list->get($targetIndex + 1));
    }

    public function testInsertIntoEmptyListWithOutBoundsIndex(): void
    {
        $list = new LinkedList();
        $list->insert(22, 12);
        assertNull($list->head);
    }

    #[DataProvider('insertingAtHeadDataProvider')]
    public function testInsertionAtHead(array $valuesToPush, int $newHead): void
    {
        $list = new LinkedList();
        foreach ($valuesToPush as $value) {
            $list->push($value);
        }
        $oldHead = $valuesToPush[0];
        assertEquals($oldHead, $list->head->value);
        $list->addAtHead($newHead);
        $newHead = $list->head->value;
        assertEquals($newHead, $newHead);
        $newListValues = [$newHead, ...$valuesToPush];

        $index = 0;
        foreach ($newListValues as $newListValue) {
            assertEquals($newListValue, $list->get($index));
            $index++;
        }
    }

    public function testDeletingAtHead(): void
    {
        $list = new LinkedList();
        $valuesToPush = [1, 3, 55, 28, 0, 5];
        foreach ($valuesToPush as $value) {
            $list->push($value);
        }
        $headValue = $valuesToPush[0];
        assertEquals($headValue, $list->deleteAtIndex(0));
        assertEquals(3, $list->head->value);
    }

    public function testDeletingInTheEnd(): void
    {
        $list = new LinkedList();
        $valuesToPush = [1, 3, 55, 28, 0, 5];
        $len = count($valuesToPush);
        foreach ($valuesToPush as $value) {
            $list->push($value);
        }

        $lastElement = $valuesToPush[$len - 1];
        assertEquals($lastElement, $list->deleteAtIndex($len - 1));
        assertEquals(-1, $list->get($len - 1));
    }

    public function testDeletingIntoMiddle(): void
    {
        $list = new LinkedList();
        $valuesToPush = [1, 3, 55, 28, 0, 5];
        foreach ($valuesToPush as $value) {
            $list->push($value);
        }
        $indexToDelete = 2;
        $valueToDelete = $valuesToPush[$indexToDelete];
        assertEquals($valueToDelete, $list->deleteAtIndex($indexToDelete));
        assertEquals($valuesToPush[$indexToDelete + 1], $list->get($indexToDelete));
        assertEquals($valuesToPush[$indexToDelete + 1], $list->get($indexToDelete));
        assertEquals($valuesToPush[$indexToDelete - 1], $list->get($indexToDelete - 1));
    }

    public static function pushingDataProvider(): array
    {
        return [
            [[4, 0, 22]],
            [[1, 2, 3, 4, 5, 6]],
            [[101, 2323, 3131, 400, 5313, 21]],
        ];
    }

    public static function gettingDataProvider(): array
    {
        // [[values...], [indexes...]]
        return [
            [[1, 2, 3, 4, 5, 6], [3, 4, 2, 5, 2, 1]],
            [[100, 2321, 333, 435, 0, 11], [0, 0, 1, 5, 2, 3]],
            [[-111, 0, -73, 88, 909], [0, 3, 1, 0]]
        ];
    }

    public static function insertingAtHeadDataProvider(): array
    {
        return [
            [[1, 2, 3, 4, 5, 6], 77],
            [[0, 0, 0, 0, 0, 0], 1],
            [[123, 2321, 431, 431, 555, 136], 777],
        ];
    }

    public static function insertingInMiddleDataProvider(): array
    {
        return [
            [[22, 34, 94, 81, 99], 12, 3],
            [[0, 2, 4, 6, 7], 5, 2],
            [[0, 2, 4, 6, 7], 1, 1],
        ];
    }
}
