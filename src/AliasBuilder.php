<?php

namespace AlfredBez\OxidDumpAutoload;

class AliasBuilder
{
    private $filter;

    public function __construct(?ClassFilterInterface $filter = null)
    {
        if ($filter === null) {
            $filter = new NullFilter();
        }
        $this->filter = $filter;
    }

    public function buildAliasesFor(array $chain): array
    {
        $aliases = [];
        foreach ($chain as $baseClass => $extendedClasses) {
            foreach ($extendedClasses as $extendedClass) {
                if ($this->filter->shouldBeFiltered($extendedClass)) {
                    continue;
                }
                $lastClassName = $lastClassName ?? $baseClass;
                $parentClassName = $extendedClass . '_parent';
                $aliases[] = [$lastClassName, $parentClassName];
                $lastClassName = $extendedClass;
            }
            $lastClassName = null;
        }

        return $aliases;
    }
}
