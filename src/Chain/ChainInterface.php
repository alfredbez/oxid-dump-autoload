<?php

namespace AlfredBez\OxidDumpAutoload\Chain;

interface ChainInterface
{
    public function getClassChain(bool $onlyActiveClasses = false): array;
}
