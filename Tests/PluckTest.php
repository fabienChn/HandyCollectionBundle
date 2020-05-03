<?php

namespace fabienChn\HandyCollectionBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use fabienChn\HandyCollectionBundle\Component\HandyCollection;

class PluckTest extends TestCase
{
    /**
     * @test
     */
    public function itPlucksTheArrayCollection()
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

        $collection = HandyCollection::collect($data);

        $this->assertEquals([1, 2], $collection->pluck('id')->toArray());
        $this->assertEquals(['Hello', 'Hi'], $collection->pluck('name')->toArray());
    }

    /**
     * @test
     */
    public function itPlucksAnEntityCollection()
    {
        $data = [
            new EntityFixture(1, 'Hello'),
            new EntityFixture(2, 'Hi'),
        ];

        $collection = HandyCollection::collect($data);

        $this->assertEquals([1, 2], $collection->pluck('id')->toArray());
        $this->assertEquals(['Hello', 'Hi'], $collection->pluck('name')->toArray());
    }
}
