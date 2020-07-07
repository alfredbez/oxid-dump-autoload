<?php

namespace AlfredBez\OxidDumpAutoload;

final class Config
{
    private $config = [
        'filter' => [],
        'source' => 'shop',
        'shopid' => 1,
        'only-active' => false,
    ];
    private $forceConfig = [];

    public function __construct(array $forceConfig = [])
    {
        $this->forceConfig = $forceConfig;
        $this->config = array_merge($this->config, $this->forceConfig);
    }

    public function load($file)
    {
        if (!file_exists($file)) {
            throw new \InvalidArgumentException("Config file $file does not exist");
        }

        $contents = file_get_contents($file);

        $json = json_decode($contents, true);

        if ((bool) $json !== true) {
            throw new \UnexpectedValueException("Could not parse $file, error: " . json_last_error_msg());
        }

        $this->config = array_merge($this->config, $json, $this->forceConfig);
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function get($configKey)
    {
        return $this->config[$configKey];
    }
}
