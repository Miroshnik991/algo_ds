<?php

declare(strict_types=1);

namespace DS;

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
        assertArraysAreEqual([0], $arr);
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
        assertArraysAreEqual([0, 3, 7, 5, 12, 177, 12], $heapArr);
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
        assertArraysAreEqual([0, 7, 12, 12, 177], $heap->get());
    }
}
