<?php

declare(strict_types=1);

namespace DS;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use src\DS\SimpleHashTable\SimpleHashTable;
use function PHPUnit\Framework\assertArraysAreEqual;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertIsInt;
use function PHPUnit\Framework\assertNull;

class TestSimpleHashTable extends TestCase
{
    public function testEmptyHashTableCreating(): void
    {
        $hashTable = new SimpleHashTable();
        assertArraysAreEqual([null, null], $hashTable->getAll());
    }

    public function testPutting(): void
    {
        $hashTable = new SimpleHashTable();

        // three 536
        // testtest 896
        // nestedArr 936
        // str 345
        $hashTable->put('three', 3);
        $hashTable->put('testtest', ['string', [123]]);
        $hashTable->put('nestedArr', [123, [123]]);
        $hashTable->put('str', 'strTest');
        $hashTable->put('testtest', 'changed value');

        assertArraysAreEqual(
            [
                ['three', 3],
                ['testtest', 'changed value'],
                ['nestedArr', [123, [123]]],
                ['str', 'strTest'],
                null,
                null,
                null,
                null,
            ],
            $hashTable->getAll(),
        );
    }

    public function testGetting(): void
    {
        $hashTable = new SimpleHashTable();
        $hashTable->put('three', 3);
        $hashTable->put('testtest', ['string', [123]]);
        $hashTable->put('nestedArr', [123, [123]]);
        $hashTable->put('str', 'strTest');

        assertEquals(3, $hashTable->get('three'));
        assertEquals(['string', [123]], $hashTable->get('testtest'));
        assertEquals([123, [123]], $hashTable->get('nestedArr'));
        assertEquals('strTest', $hashTable->get('str'));
    }

    public function testGettingUnexistedElement(): void
    {
        $hashTable = new SimpleHashTable();
        $hashTable->put('three', 3);
        $hashTable->put('testtest', ['string', [123]]);
        assertNull($hashTable->get('not_existed'));
    }

    #[DataProvider('hashProvider')]
    public function testHash(string $str, int|float $expectedHash): void
    {
        $hashTable = new SimpleHashTable();
        $testHash = $hashTable->hash($str);
        assertIsInt($testHash);
        assertEquals($expectedHash, $testHash);
    }

    public function testRehash(): void
    {
        $hashTable = new SimpleHashTable();
        assertCount(2, $hashTable->getAll());
        $hashTable->put('str', ['str']);
        assertCount(2, $hashTable->getAll());
        assertArraysAreEqual([null, ['str', ['str']]], $hashTable->getAll());
        $hashTable->put('abrakadabra', ['abrakadabra', 1, [], true]);
        assertCount(4, $hashTable->getAll());
        assertArraysAreEqual(
            [
                ['abrakadabra', ['abrakadabra', 1, [], true]],
                ['str', ['str']],
                null,
                null,
            ],
            $hashTable->getAll()
        );
        $hashTable->put('processing', 'processing');
        assertCount(4, $hashTable->getAll());
        assertArraysAreEqual(
            [
                ['abrakadabra', ['abrakadabra', 1, [], true]],
                ['str', ['str']],
                ['processing', 'processing'],
                null,
            ],
            $hashTable->getAll()
        );

        $hashTable->put('test', [true]);
        assertCount(8, $hashTable->getAll());
        assertArraysAreEqual(
            [
                ['test', [true]],
                ['str', ['str']],
                null,
                null,
                ['abrakadabra', ['abrakadabra', 1, [], true]],
                ['processing', 'processing'],
                null,
                null,
            ],
            $hashTable->getAll()
        );
        $hashTable->put('TeSt', 111);
        assertCount(8, $hashTable->getAll());
        assertArraysAreEqual(
            [
                ['test', [true]],
                ['str', ['str']],
                ['TeSt', 111],
                null,
                ['abrakadabra', ['abrakadabra', 1, [], true]],
                ['processing', 'processing'],
                null,
                null,
            ],
            $hashTable->getAll()
        );
    }

    public static function hashProvider(): array
    {
        return [
            ['str', 345],
            ['abrakadabra', 1116],
            ['processing', 1085],
            ['test', 448],
            ['TeSt', 384],
        ];
    }
}
