<?php

namespace AlfredBez\OxidDumpAutoload;

class NullFilter implements ClassFilterInterface
{
    public function shouldBeFiltered($element): bool
    {
        return false;
    }
}
