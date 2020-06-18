<?php

namespace AlfredBez\OxidDumpAutoload\Tests;

use AlfredBez\OxidDumpAutoload\AliasDumper;
use PHPUnit\Framework\TestCase;

class AliasDumperTest extends TestCase
{
    public function testDumpMethod()
    {
        $aliases = [
            ['class1', 'aliasclass'],
            ['class2', 'aliasclass2'],
        ];
        $dumper = new AliasDumper();

        $this->assertEquals(
            '<?php class_alias("class1", "aliasclass");' . PHP_EOL
            . 'class_alias("class2", "aliasclass2");' . PHP_EOL,
            $dumper->dump($aliases)
        );
    }
}
