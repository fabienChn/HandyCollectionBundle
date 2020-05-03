<?php

namespace fabienChn\HandyCollectionBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use fabienChn\HandyCollectionBundle\Component\HandyCollection;

class EachTest extends TestCase
{
    /**
     * @test
     */
    public function itLoopsThroughAnArrayCollection()
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

        $eachedCollection = $collection->each(function ($item, $key) {
            return [
                'id' => 5 + $key,
                'name' => $item['name']
            ];
        });

        $expectedArray = [
            [
                'id' => 5,
                'name' => 'Hello'
            ],
            [
                'id' => 6,
                'name' => 'Hi'
            ],
        ];

        $this->assertInstanceOf(HandyCollection::class, $eachedCollection);

        $this->assertEquals($expectedArray, $eachedCollection->toArray());
    }

    /**
     * @test
     */
    public function itLoopsThroughAnEntityCollection()
    {
        $data = [
            new EntityFixture(1, 'Hello'),
            new EntityFixture(2, 'Hi'),
        ];

        $collection = HandyCollection::collect($data);

        $eachedCollection = $collection->each(function ($item, $key) {
            return [
                'id' => 5 + $key,
                'name' => $item->getName()
            ];
        });

        $expectedArray = [
            [
                'id' => 5,
                'name' => 'Hello'
            ],
            [
                'id' => 6,
                'name' => 'Hi'
            ],
        ];

        $this->assertInstanceOf(HandyCollection::class, $eachedCollection);

        $this->assertEquals($expectedArray, $eachedCollection->toArray());
    }

    /**
     * @test
     */
    public function itStopsTheLoopingWhenReturningFalse()
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

        $eachedCollection = $collection->each(function ($item, $key) {
            if ($key == 1) {
                return false;
            }

            return [
                'id' => 99,
                'name' => $item['name']
            ];
        });

        $expectedArray = [
            [
                'id' => 99,
                'name' => 'Hello'
            ],
        ];

        $this->assertInstanceOf(HandyCollection::class, $eachedCollection);

        $this->assertEquals($expectedArray, $eachedCollection->toArray());
    }
}
