<?php

namespace AlfredBez\OxidDumpAutoload;

final class ClassFilter implements ClassFilterInterface
{
    private $filters = [];

    public static function fromString(?string $filter = '')
    {
        $filters = explode(',', $filter);

        return new self($filters);
    }

    public static function fromArray(array $filter = [])
    {
        return new self($filter);
    }

    private function __construct(array $filter)
    {
        $this->filters = $filter;
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
