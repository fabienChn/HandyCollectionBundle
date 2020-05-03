<?php

namespace fabienChn\HandyCollectionBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use fabienChn\HandyCollectionBundle\Component\HandyCollection;

class FilterTest extends TestCase
{
    /**
     * @test
     */
    public function itFiltersAnArrayCollection()
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
            [
                'id' => 3,
                'name' => 'Hello'
            ]
        ];

        $collection = HandyCollection::collect($data);

        $filteredCollection = $collection->filter(function ($item) {
            return $item['id'] < 3;
        });

        $expectedArray = [
            [
                'id' => 1,
                'name' => 'Hello'
            ],
            [
                'id' => 2,
                'name' => 'Hi'
            ],
        ];

        $this->assertInstanceOf(HandyCollection::class, $filteredCollection);

        $this->assertEquals($expectedArray, $filteredCollection->toArray());
    }

    /**
     * @test
     */
    public function itFiltersAnEntityCollection()
    {
        $data = [
            new EntityFixture(1, 'Hello'),
            new EntityFixture(2, 'Hi'),
            new EntityFixture(3, 'Hello'),
        ];

        $collection = HandyCollection::collect($data);

        $filteredCollection = $collection->filter(function ($item) {
            return $item->getName() === 'Hello';
        });

        $expectedArray = [
            0 => new EntityFixture(1, 'Hello'),
            2 => new EntityFixture(3, 'Hello'),
        ];

        $this->assertInstanceOf(HandyCollection::class, $filteredCollection);

        $this->assertEquals($expectedArray, $filteredCollection->toArray());
    }

    /**
     * @test
     */
    public function itGivesTheRightKeyWhenFiltering()
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
            [
                'id' => 3,
                'name' => 'Hello'
            ]
        ];

        $collection = HandyCollection::collect($data);

        $filteredCollection = $collection->filter(function ($item, $key) {
            return $item && $key === 0;
        });

        $expectedArray = [
            [
                'id' => 1,
                'name' => 'Hello'
            ],
        ];

        $this->assertInstanceOf(HandyCollection::class, $filteredCollection);

        $this->assertEquals($expectedArray, $filteredCollection->toArray());
    }
}
