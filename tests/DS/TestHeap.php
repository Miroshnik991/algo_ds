<?php

declare(strict_types=1);

namespace tests\DS;

require_once 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use src\DS\Heap\Heap;
use function PHPUnit\Framework\assertArraysAreEqual;
use function PHPUnit\Framework\assertEquals;

class TestHeap extends TestCase
{
    public function testHeapCreation(): void
    {
        $heap = new Heap();
        $arr = $heap->get();
        assertArraysAreEqual([], $arr);
    }

    public function testHeapPushing(): void
    {
        $heap = new Heap();
        $heap->push(5);
        $heap->push(7);
        $heap->push(12);
        $heap->push(12);
        $heap->push(177);
        $heap->push(3);
        $heapArr = $heap->get();
        assertArraysAreEqual([3, 7, 5, 12, 177, 12], $heapArr);
    }

    public function testHeapPopping(): void
    {
        $heap = new Heap();
        $heap->push(5);
        $heap->push(7);
        $heap->push(12);
        $heap->push(12);
        $heap->push(177);
        $heap->push(3);
        $val1 = $heap->pop();
        assertEquals(3, $val1);
        $val2 = $heap->pop();
        assertEquals(5, $val2);
        assertArraysAreEqual([7, 12, 12, 177], $heap->get());
    }

    public function testHeapHeapify(): void
    {
        $arr = [12, 3, 7, 12, 5, 177];
        $heap = new Heap();
        $heap->heapify($arr);
        assertArraysAreEqual([3, 5, 12, 7, 177, 12], $heap->get());
    }

    public function testHeapHeapifyWithEmptyArray(): void
    {
        $heap = new Heap();
        $heap->heapify([]);
        assertArraysAreEqual([], $heap->get());
    }
}
