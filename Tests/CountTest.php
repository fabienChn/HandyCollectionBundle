<?php

namespace fabienChn\HandyCollectionBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use fabienChn\HandyCollectionBundle\Component\HandyCollection;

class CountTest extends TestCase
{
    /**
     * @test
     */
    public function itCountsTheItemsOfAnArrayCollectionThatMatchTheFunctionsCalculations()
    {
        $data = [
            ['id' => 1],
            ['id' => 2],
        ];

        $collection = HandyCollection::collect($data);

        $count = $collection->count(function ($item) {
            return $item['id'] === 1;
        });

        $this->assertInternalType('int', $count);

        $this->assertEquals(1, $count);
    }
}
