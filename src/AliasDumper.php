<?php

namespace AlfredBez\OxidDumpAutoload;

class AliasDumper
{
    public function dump(array $aliases): string
    {
        $output = '<?php ';
        foreach ($aliases as $aliasPair) {
            $output .= 'class_alias("' . $aliasPair[0] . '", "' . $aliasPair[1] . '");' . PHP_EOL;
        }

        return $output;
    }
}
