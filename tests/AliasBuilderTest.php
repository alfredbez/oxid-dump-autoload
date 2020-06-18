<?php

namespace AlfredBez\OxidDumpAutoload\Tests;

use AlfredBez\OxidDumpAutoload\AliasBuilder;
use AlfredBez\OxidDumpAutoload\ClassFilterInterface;
use PHPUnit\Framework\TestCase;

class AliasBuilderTest extends TestCase
{
    public function testBuildsAliases()
    {
        $chain = [
            'Article' => [
                'Article1',
                'Article2',
                'Article3',
            ]
        ];
        $aliasBuilder = new AliasBuilder();

        $result = $aliasBuilder->buildAliasesFor($chain);

        $this->assertEquals(
            [
                ['Article', 'Article1_parent'],
                ['Article1', 'Article2_parent'],
                ['Article2', 'Article3_parent'],
            ],
            $result
        );
    }

    /**
     * @dataProvider filterDataProvider
     */
    public function testFiltersExcludedClasses($chain, $expectedOutput)
    {
        $fakeFilter = new class implements ClassFilterInterface {
            public function shouldBeFiltered($element): bool
            {
                return strpos($element, 'Vendor2') !== false;
            }
        };
        $aliasBuilder = new AliasBuilder($fakeFilter);

        $result = $aliasBuilder->buildAliasesFor($chain);

        $this->assertEquals($expectedOutput, $result);
    }

    public function filterDataProvider()
    {
        return [
            'remove class from the beginning of a chain' => [
                [
                    'Article' => [
                        'Vendor2\Article',
                        'Vendor1\Article',
                        'Vendor3\Article',
                    ]
                ],
                [
                    ['Article', 'Vendor1\Article_parent'],
                    ['Vendor1\Article', 'Vendor3\Article_parent'],
                ],
            ],
            'remove class from the middle of a chain' => [
                [
                    'Article' => [
                        'Vendor1\Article',
                        'Vendor2\Article',
                        'Vendor3\Article',
                    ]
                ],
                [
                    ['Article', 'Vendor1\Article_parent'],
                    ['Vendor1\Article', 'Vendor3\Article_parent'],
                ],
            ],
            'remove class from the end of a chain' => [
                [
                    'Article' => [
                        'Vendor1\Article',
                        'Vendor3\Article',
                        'Vendor2\Article',
                    ]
                ],
                [
                    ['Article', 'Vendor1\Article_parent'],
                    ['Vendor1\Article', 'Vendor3\Article_parent'],
                ],
            ],
            'remove classes from a vendor in several base classes ' => [
                [
                    'Article' => [
                        'Vendor1\Article',
                        'Vendor2\Article',
                        'Vendor3\Article',
                    ],
                    'Category' => [
                        'Vendor2\Category',
                    ],
                ],
                [
                    ['Article', 'Vendor1\Article_parent'],
                    ['Vendor1\Article', 'Vendor3\Article_parent'],
                ],
            ],
        ];
    }
}
