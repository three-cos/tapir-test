<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use Warden\CarAPI\Filter\Filter;
use Warden\CarAPI\Filter\FromFilter;
use Warden\CarAPI\Filter\LikeFilter;
use Warden\CarAPI\Filter\ToFilter;

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

    public function testFilterFromSignature()
    {
        $filter = new FromFilter('param_from', 100);

        $this->assertTrue($filter->match('param_from'));
        $this->assertFalse($filter->match('wrongParam'));
    }

    public function testFilterToSignature()
    {
        $filter = new ToFilter('param_to', 200);

        $this->assertTrue($filter->match('param_to'));
        $this->assertFalse($filter->match('wrongParam'));
    }

    public function testFilterLikeSignature()
    {
        $filter = new LikeFilter('param_like', 'carModel');

        $this->assertTrue($filter->match('param_like'));
        $this->assertFalse($filter->match('wrongParam'));
    }
}
