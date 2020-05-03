<?php

namespace fabienChn\HandyCollectionBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use fabienChn\HandyCollectionBundle\Component\HandyCollection;

class CollapseTest extends TestCase
{
    /**
     * @test
     */
    public function itCollapsesAnArrayCollectionOfArraysOfArraysIntoAnArrayCollection()
    {
        $data = [
            [
                ['id' => 1],
                ['id' => 2],
            ],
            [
                ['id' => 1],
                ['id' => 2],
            ],
        ];

        $collection = HandyCollection::collect($data);

        $this->assertEquals([
            ['id' => 1],
            ['id' => 2],
            ['id' => 1],
            ['id' => 2],
        ], $collection->collapse()->toArray());
    }

    /**
     * @test
     */
    public function itCollapsesAnArrayCollectionOfArraysOfEntitiesIntoAnArrayCollection()
    {
        $data = [
            [
                new EntityFixture(1, 'Hello'),
                new EntityFixture(2, 'Hello'),
            ],
            [
                new EntityFixture(1, 'Hello'),
                new EntityFixture(2, 'Hello'),
            ],
        ];

        $collection = HandyCollection::collect($data);

        $this->assertEquals(
            [
                new EntityFixture(1, 'Hello'),
                new EntityFixture(2, 'Hello'),
                new EntityFixture(1, 'Hello'),
                new EntityFixture(2, 'Hello'),
            ],
            $collection->collapse()->toArray()
        );
    }
}
