<?php

namespace AlfredBez\OxidDumpAutoload;

final class ClassFilter implements ClassFilterInterface
{
    private $filters = [];

    public function __construct(?string $filter = '')
    {
        $this->filters = explode(',', $filter);
    }

    public function shouldBeFiltered($element): bool
    {
        foreach ($this->filters as $filter) {
            if (strpos($element, trim($filter)) !== false) {
                return true;
            }
        }

        return false;
    }
}
