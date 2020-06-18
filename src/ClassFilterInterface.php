<?php

namespace AlfredBez\OxidDumpAutoload;

interface ClassFilterInterface
{
    public function shouldBeFiltered($element): bool;
}
