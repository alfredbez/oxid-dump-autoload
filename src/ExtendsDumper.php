<?php

namespace AlfredBez\OxidDumpAutoload;

class ExtendsDumper
{
    public function dump(array $aliases): string
    {
        $output = '<?php ';
        foreach ($aliases as $aliasPair) {

            list($lastClassName, $moduleClass) = $aliasPair;
            $ns = '';
            $class = $moduleClass;
            if (preg_match("/(.*)\\\\(.*)/",$moduleClass,$matches)) {
                $ns = $matches[1];
                $class = $matches[2];
            }
            $output .=<<<PHP
                namespace ${ns}{
                    class $class extends \\$lastClassName{
                    }
                }
PHP;
        }

        return $output;
    }
}
