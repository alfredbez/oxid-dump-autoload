<?php

namespace AlfredBez\OxidDumpAutoload\Chain;

final class ChainFactory
{
    public static function createChainFor($source): ChainInterface
    {
        if (strpos($source, 'metadata.php') !== false) {
            return new MetadataChain($source);
        }
        if (strpos($source, '/modules/') !== false) {
            return new MetadataChain($source);
        }

        return new ShopChain($source);
    }
}

