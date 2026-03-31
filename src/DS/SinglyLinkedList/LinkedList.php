<?php

declare(strict_types=1);

namespace src\DS\SinglyLinkedList;

class LinkedList
{
    public function __construct(
        public ?Node $head = null,
    )  {}

    public function push(int $value): static
    {
        if (is_null($this->head)) {
            $this->head = new Node($value);
            return $this;
        }

        $cur = $this->head;
        while ($cur->next) {
            $cur = $cur->next;
        }

        $cur->next = new Node($value);
        return $this;
    }

    public function get(int $index): int
    {
        $cur = $this->head;
        $counter = 0;
        while ($cur) {
            if ($counter == $index) {
                return $cur->value;
            }
            $counter++;
            $cur = $cur->next;
        }

        return -1;
    }

    public function insert(int $index, int $value): static
    {
        $cur = $this->head;
        $counter = 0;
        while ($cur) {
            if ($counter == $index) {
                $oldNode = $cur;
                $newNode = new Node($value);
                $newNode->next = $oldNode;
                $prevNode = $this->getNodeByIndex($index - 1);
                $prevNode->next = $newNode;
                return $this;
            }
            $counter++;
            $cur = $cur->next;
        }

        return $this;
    }


    private function getNodeByIndex(int $index): ?Node
    {
        $cur = $this->head;
        $counter = 0;
        while ($cur) {
            if ($counter == $index) {
                return $cur;
            }
            $counter++;
            $cur = $cur->next;
        }
        return null;
    }

    public function addAtHead(int $value): static
    {
        if (is_null($this->head)) {
            $this->head = new Node($value);
            return $this;
        }
        $oldHead = $this->head;
        $this->head = new Node($value);
        $this->head->next = $oldHead;

        return $this;
    }

    public function deleteAtIndex(int $index): int
    {
        if ($index === 0) {
            $oldHead = $this->head;
            $this->head = $oldHead->next;
            return $oldHead->value;
        }
        $cur = $this->head;
        $counter = 0;
        while ($cur) {
            if ($counter == $index) {
                $oldValue = $cur->value;
                $prevNode = $this->getNodeByIndex($index - 1);
                if (is_null($cur->next)) {
                    $prevNode->next = null;
                } else {
                    $prevNode->next = $cur->next;
                }
                return $oldValue;
            }
            $counter++;
            $cur = $cur->next;
        }
        return -1;
    }
}
