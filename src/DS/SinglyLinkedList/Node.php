<?php

declare(strict_types=1);

namespace src\DS\SinglyLinkedList;

class Node
{
    public function __construct(
        public int $value,
        public ?Node $next = null
    ) {}
}
