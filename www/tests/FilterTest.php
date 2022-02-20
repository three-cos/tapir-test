<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use Warden\CarAPI\Filter\Filter;

class FilterTest extends TestCase
{
    public function testIsFilter()
    {
        $items = [
            [
                'car' => 'car 1',
                'param' => 'not_match',
            ],
            [
                'car' => 'car 2',
                'param' => 'match',
            ],
            [
                'car' => 'car 3',
                'param' => 'not_match',
            ]
        ];

        $filter = Filter::create('param_is', 'match');

        $result = $filter->filter($items);

        $this->assertSame([[
            'car' => 'car 2',
            'param' => 'match',
        ]], $result);
    }

    public function testFromFilter()
    {
        $items = [
            [
                'car' => 'car 1',
                'param' => '100',
            ],
            [
                'car' => 'car 2',
                'param' => '150',
            ],
            [
                'car' => 'car 3',
                'param' => '200',
            ],
            [
                'car' => 'car 4',
                'param' => '250',
            ]
        ];

        $filter = Filter::create('param_from', 200);

        $result = $filter->filter($items);

        $this->assertSame([
            [
                'car' => 'car 3',
                'param' => '200',
            ],
            [
                'car' => 'car 4',
                'param' => '250',
            ]
        ], $result);
    }
}
