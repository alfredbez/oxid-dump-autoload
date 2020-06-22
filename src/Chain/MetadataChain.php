<?php

namespace AlfredBez\OxidDumpAutoload\Chain;

final class MetadataChain
{
    private $data;

    public function __construct($source)
    {
        if (!file_exists($source)) {
            throw new \InvalidArgumentException("Metadata-File $source not found");
        }

        include $source;

        $this->data = $aModule;
    }

    public function getClassChain(): array
    {
        $chain = [];
        foreach ($this->data['extend'] as $baseClass => $extendsClass) {
            $chain[$baseClass] = [$extendsClass];
        }

        return $chain;
    }
}
