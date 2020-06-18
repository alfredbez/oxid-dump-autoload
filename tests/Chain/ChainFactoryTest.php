<?php

namespace AlfredBez\OxidDumpAutoload\Tests\Chain;

use PHPUnit\Framework\TestCase;
use AlfredBez\OxidDumpAutoload\Chain\{ShopChain,MetadataChain,ChainFactory};

class ChainFactoryTest extends TestCase
{
    public function testReturnsMetadataChainIfMetadataIsGiven()
    {
        $source = 'path/to/my/module/metadata.php';

        $chain = ChainFactory::createChainFor($source);

        $this->assertInstanceOf(MetadataChain::class, $chain);
    }

    public function testReturnsMetadataChainIfPathToModuleIsGiven()
    {
        $source = 'source/modules/oxps/mymodule/';

        $chain = ChainFactory::createChainFor($source);

        $this->assertInstanceOf(MetadataChain::class, $chain);
    }

    public function testReturnsShopChainClassIfNoModuleIsGiven()
    {
        $this->expectException(\RuntimeException::class);
        $chain = ChainFactory::createChainFor('');

        $this->assertInstanceOf(ShopChain::class, $chain);
    }
}
