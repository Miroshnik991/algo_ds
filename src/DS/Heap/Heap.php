<?php

declare(strict_types=1);

namespace src\DS\Heap;

class Heap
{
    private const int HEAP_OFFSET_WITHOUT_DUMMY = 1;


    public function __construct(
        protected array $heap = [0],
    ) {}

    public function get(): array
    {
        return array_slice($this->heap, self::HEAP_OFFSET_WITHOUT_DUMMY);
    }

    public function push(int $num): void
    {
        $this->heap[] = $num;
        $i = count($this->heap) - 1;

        while ($this->heap[$i] < $this->heap[intdiv($i,2)]) {
            $tmp = $this->heap[$i];
            $this->heap[$i] = $this->heap[intdiv($i,2)];
            $this->heap[intdiv($i,2)] = $tmp;
            $i = intdiv($i,2);
        }
    }

    public function pop(): int
    {
        $res = $this->heap[1];

        $this->heap[1] = array_pop($this->heap);
        $i = 1;

        while ($i * 2 < count($this->heap)) {
            if (
                ($i * 2 + 1 < count($this->heap))
                && $this->heap[$i * 2 + 1] < $this->heap[$i * 2]
                && $this->heap[$i * 2 + 1] < $this->heap[$i]
            ) {
                $tmp = $this->heap[$i];
                $this->heap[$i] = $this->heap[$i * 2 + 1];
                $this->heap[$i * 2 + 1] = $tmp;
                $i = $i * 2 + 1;
            }
            else if ($this->heap[$i * 2] < $this->heap[$i]) {
                $tmp = $this->heap[$i];
                $this->heap[$i] = $this->heap[$i * 2];
                $this->heap[$i * 2] = $tmp;
                $i = $i * 2;
            } else {
                break;
            }
        }

        return $res;
    }

    public function heapify(array $arr): static
    {
        if (empty($arr)) {
            return $this;
        }

        $this->heap = $arr;
        $this->heap[] = $arr[0];
        $cur = intdiv(count($arr), 2);

        while ($cur > 0) {
            $i = $cur;
            while ($i * 2 < count($this->heap)) {
                if (
                    $i * 2 + 1 < count($this->heap)
                    && $this->heap[$i * 2 + 1] < $this->heap[$i * 2]
                    && $this->heap[$i * 2 + 1] < $this->heap[$i]
                ) {
                    $tmp = $this->heap[$i];
                    $this->heap[$i] = $this->heap[$i * 2 + 1];
                    $this->heap[$i * 2 + 1] = $tmp;
                    $i = $i * 2 + 1;
                } else if ($this->heap[$i * 2] < $this->heap[$i]) {
                    $tmp = $this->heap[$i];
                    $this->heap[$i] = $this->heap[$i * 2];
                    $this->heap[$i * 2] = $tmp;
                    $i = $i * 2;
                } else break;
            }
            $cur--;
        }

        return $this;
    }
}
