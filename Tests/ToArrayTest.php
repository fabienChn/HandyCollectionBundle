<?php

namespace fabienChn\HandyCollectionBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use fabienChn\HandyCollectionBundle\Component\HandyCollection;

class ToArrayTest extends TestCase
{
    /**
     * @test
     */
    public function itConvertsAnArrayCollectionToAnArrayOfArrays()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'Hello'
            ],
            [
                'id' => 2,
                'name' => 'Hi'
            ],
        ];

        $array = HandyCollection::collect($data)->toArray();

        $this->assertEquals($data, $array);
    }

    /**
     * @test
     */
    public function itConvertsAnEntityCollectionToAnArrayOfEntities()
    {
        $data = [
            new EntityFixture(1, 'Hello'),
            new EntityFixture(2, 'Hi'),
        ];

        $array = HandyCollection::collect($data)->toArray();

        $this->assertEquals($data, $array);
    }
}
