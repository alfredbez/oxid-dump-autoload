<?php

namespace AlfredBez\OxidDumpAutoload\Tests;

use PHPUnit\Framework\TestCase;
use AlfredBez\OxidDumpAutoload\Config;

class ConfigTest extends TestCase
{
    public function testLoadsConfigFile()
    {
        $loader = new Config();
        $loader->load(__DIR__ . '/fixtures/valid-config.json');

        $this->assertEquals([], $loader->get('filter'));
    }

    public function testDoesNotLoadNonExistingConfigFile()
    {
        $this->expectException(\InvalidArgumentException::class);
        $loader = new Config();

        $loader->load('I/do/not/exist.json');
    }

    public function testDoesThrowExceptionIfConfigFileHasSyntaxError()
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessageMatches('/Could not parse .*\/syntax-error-in-config\.json, error: Syntax error/');

        $loader = new Config();
        $loader->load(__DIR__ . '/fixtures/syntax-error-in-config.json');
    }

    public function testReadsFilterFromConfigFile()
    {
        $loader = new Config();
        $loader->load(__DIR__ . '/fixtures/config-with-filter.json');

        $this->assertEquals(
            [
                "legacymodule1/",
                "legacymodule2/",
                "Psr4ClassWithoutNamespace",
                "VendorName\ModuleName",
            ],
            $loader->get('filter')
        );
    }

    public function testGetReturnsSingleConfigValue()
    {
        $loader = new Config();
        $loader->load(__DIR__ . '/fixtures/config-with-filter.json');

        $this->assertEquals(
            [
                "legacymodule1/",
                "legacymodule2/",
                "Psr4ClassWithoutNamespace",
                "VendorName\ModuleName",
            ],
            $loader->get('filter')
        );
    }

    public function testPassedConfigOverwritesConfigFromFile()
    {
        $loader = new Config(['filter' => []]);
        $loader->load(__DIR__ . '/fixtures/config-with-filter.json');

        $this->assertEquals([], $loader->get('filter'));
    }

    public function testPassedConfigWorksWithoutLoadingAConfig()
    {
        $loader = new Config(['filter' => ['foo']]);

        $this->assertEquals(['foo'], $loader->get('filter'));
    }

    public function testLoadingCustomConfigDoesNotOverwriteDefaultValuesThatAreNotTouched()
    {
        $loader = new Config();
        $loader->load(__DIR__ . '/fixtures/config-with-filter.json');

        $this->assertEquals('shop', $loader->get('source'));
    }
}
