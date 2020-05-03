<?php

namespace fabienChn\HandyCollectionBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use fabienChn\HandyCollectionBundle\Component\HandyCollection;

class MapTest extends TestCase
{
    /**
     * @test
     */
    public function itMapsAnArrayCollection()
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

        $mappedCollection = $collection->map(function ($item, $key) {
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

        $this->assertInstanceOf(HandyCollection::class, $mappedCollection);

        $this->assertEquals($expectedArray, $mappedCollection->toArray());
    }

    /**
     * @test
     */
    public function itMapsAnEntityCollection()
    {
        $data = [
            new EntityFixture(1, 'Hello'),
            new EntityFixture(2, 'Hi'),
        ];

        $collection = HandyCollection::collect($data);

        $mappedCollection = $collection->map(function ($item, $key) {
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

        $this->assertInstanceOf(HandyCollection::class, $mappedCollection);

        $this->assertEquals($expectedArray, $mappedCollection->toArray());
    }
}
