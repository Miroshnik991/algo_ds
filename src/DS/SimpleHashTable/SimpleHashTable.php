<?php

declare(strict_types=1);

namespace src\DS\SimpleHashTable;

class SimpleHashTable
{
    public int $size;
    public int $capacity;
    public array $hashMap;

    public function __construct()
    {
        $this->size = 0;
        $this->capacity = 2;
        $this->hashMap = [null, null];
    }

    public function getAll(): array
    {
        return $this->hashMap;
    }

    public function get(string $key): mixed
    {
        $index = $this->getPredictedIndex($key);

        while ($index < $this->capacity) {
            if (
                is_array($this->hashMap[$index])
                && $this->hashMap[$index][0] === $key
            ) {
                return $this->hashMap[$index][1];
            }
            $index++;
        }

        return null;
    }

    public function put(string $key, $value): void
    {
        $index = $this->getPredictedIndex($key);
        while (true) {
            if (is_null($this->hashMap[$index])) {
                $this->hashMap[$index] = [$key, $value];
                $this->size++;
                if ($this->size >= $this->capacity) {
                    $this->rehash();
                }
                return;
            } elseif ($this->hashMap[$index][0] == $key) {
                $this->hashMap[$index][1] = $value;
                return;
            }
            $index++;
            $index = $index % $this->capacity;
        }
    }

    public function rehash(): void
    {
        $this->capacity = $this->size * 2;
        $newHashMap = [];

        for ($i = 0; $i < $this->capacity; $i++) {
            $newHashMap[] = null;
        }

        $oldHashMap = $this->hashMap;
        $this->hashMap = $newHashMap;
        $this->size = 0;
        foreach ($oldHashMap as $item) {
            if ($item) {
                $this->put($item[0], $item[1]);
            }
        }
    }

    public function hash(string $key): int
    {
        $strArr = str_split($key);
        $hash = 0;
        foreach ($strArr as $str) {
             $hash += ord($str);
        }

        return $hash;
    }


    private function getPredictedIndex(string $key): int
    {
        return $this->hash($key) % $this->capacity;
    }
}
