<?php

namespace fabienChn\HandyCollectionBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use fabienChn\HandyCollectionBundle\Component\HandyCollection;

class TransformTest extends TestCase
{
    /**
     * @test
     */
    public function itTransformsAnArrayCollection()
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

        $collection->transform(function ($item, $key) {
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

        $this->assertInstanceOf(HandyCollection::class, $collection);

        $this->assertEquals($expectedArray, $collection->toArray());
    }

    /**
     * @test
     */
    public function itTransformsAnEntityCollection()
    {
        $data = [
            new EntityFixture(1, 'Hello'),
            new EntityFixture(2, 'Hi'),
        ];

        $collection = HandyCollection::collect($data);

        $collection->transform(function ($item, $key) {
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

        $this->assertInstanceOf(HandyCollection::class, $collection);

        $this->assertEquals($expectedArray, $collection->toArray());
    }
}
