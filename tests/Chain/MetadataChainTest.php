<?php

namespace AlfredBez\OxidDumpAutoload\Tests\Chain;

use PHPUnit\Framework\TestCase;
use AlfredBez\OxidDumpAutoload\Chain\MetadataChain;

class MetadataChainTest extends TestCase
{
    public function testGetClassChain()
    {
        $metadataChain = new MetadataChain('tests/fixtures/modules/mymodule/metadata.php');

        $chain = $metadataChain->getClassChain();

        $this->assertEquals(
            [
                '\OxidEsales\Eshop\Core\ShopControl' => ['\MyVendor\MyModule\Core\ShopControl'],
                '\OxidEsales\Eshop\Core\Foo' => ['\MyVendor\MyModule\Core\Bar'],
            ],
            $chain
        );
    }

    public function testThrowsExceptionIfMetadataFileNotFound()
    {
        $this->expectException(\InvalidArgumentException::class);

        new MetadataChain('I/do/not/exist/metadata.php');
    }
}
