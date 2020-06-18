<?php

namespace AlfredBez\OxidDumpAutoload\Tests;

use AlfredBez\OxidDumpAutoload\ClassFilter;
use PHPUnit\Framework\TestCase;

class ClassFilterTest extends TestCase
{
    public function testCanFilterSingleString()
    {
        $filter = new ClassFilter('vendor1');

        $this->assertFalse($filter->shouldBeFiltered('oe/tags/bla'));
        $this->assertTrue($filter->shouldBeFiltered('vendor1/tags/bla'));
    }

    public function testWorksWithMultipleFiltersAndWhitespace()
    {
        //                      This space is here on purpose
        //                                 |
        //                                 v
        $filter = new ClassFilter('vendor1, oe/');

        $this->assertTrue($filter->shouldBeFiltered('oe/tags/bla'));
        $this->assertTrue($filter->shouldBeFiltered('vendor1/tags/bla'));
        $this->assertFalse($filter->shouldBeFiltered('oetest/foo'));
    }
}
