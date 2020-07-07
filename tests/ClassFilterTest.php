<?php

namespace AlfredBez\OxidDumpAutoload\Tests;

use AlfredBez\OxidDumpAutoload\ClassFilter;
use PHPUnit\Framework\TestCase;

class ClassFilterTest extends TestCase
{
    public function testCanFilterSingleString()
    {
        $filter = ClassFilter::fromString('vendor1');

        $this->assertFalse($filter->shouldBeFiltered('oe/tags/bla'));
        $this->assertTrue($filter->shouldBeFiltered('vendor1/tags/bla'));
    }

    public function testWorksWithMultipleFiltersAndWhitespace()
    {
        //                              This space is here on purpose
        //                                         |
        //                                         v
        $filter = ClassFilter::fromString('vendor1, oe/');

        $this->assertTrue($filter->shouldBeFiltered('oe/tags/bla'));
        $this->assertTrue($filter->shouldBeFiltered('vendor1/tags/bla'));
        $this->assertFalse($filter->shouldBeFiltered('oetest/foo'));
    }

    public function testCanBeCreatedWithArray()
    {
        $filter = ClassFilter::fromArray(['vendor1', 'vendor2']);

        $this->assertFalse($filter->shouldBeFiltered('oe/tags/bla'));
        $this->assertTrue($filter->shouldBeFiltered('vendor1/tags/bla'));
        $this->assertTrue($filter->shouldBeFiltered('vendor2/tags/bla'));
    }
}
