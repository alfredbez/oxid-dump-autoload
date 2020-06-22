<?php

namespace AlfredBez\OxidDumpAutoload\Chain;

use OxidEsales\Eshop\Core\FileCache;
use OxidEsales\Eshop\Core\Module\ModuleChainsGenerator;
use OxidEsales\Eshop\Core\Module\ModuleVariablesLocator;
use RuntimeException;

final class ShopChain
{
    public function __construct()
    {
        $this->loadBootstrap();
    }

    public function getClassChain(bool $onlyActiveClasses = false, int $shopId = 1): array
    {
        $fileCache = new FileCache();
        $shopIdcalculator = new class ($shopId) {
            private $shopId;
            public function __construct(int $shopId)
            {
                $this->shopId = $shopId;
            }
            public function getShopId()
            {
                return $this->shopId;
            }
        };
        $variablesLocator = new ModuleVariablesLocator($fileCache, $shopIdcalculator);
        $moduleChainGenerator = new ModuleChainsGenerator($variablesLocator);

        if ($onlyActiveClasses) {
            return $this->getChainForActiveClasses($moduleChainGenerator);
        }

        return $this->getChainForAllClasses($moduleChainGenerator);
    }

    private function getChainForActiveClasses($moduleChainGenerator)
    {
        $chain = [];

        $modules = $moduleChainGenerator->getModuleVariablesLocator()->getModuleVariable('aModules');
        foreach (array_keys($modules) as $baseClassName) {
            $chain[$baseClassName] = $moduleChainGenerator->getActiveChain($baseClassName);
        }

        return $chain;
    }

    private function getChainForAllClasses($moduleChainGenerator)
    {
        $chain = [];
        $modules = $moduleChainGenerator->getModuleVariablesLocator()->getModuleVariable('aModules');
        foreach ($modules as $baseClassName => $classChain) {
            $chain[$baseClassName] = explode('&', $classChain);
        }

        return $chain;
    }

    private function loadBootstrap()
    {
        $possiblePathsForBootstrap = [
            implode(DIRECTORY_SEPARATOR, [__DIR__, '..', '..', '..', 'source', 'bootstrap.php']),
            implode(DIRECTORY_SEPARATOR, [__DIR__, '..', '..', '..', '..', 'source', 'bootstrap.php']),
            implode(DIRECTORY_SEPARATOR, ['', 'var', 'www', 'oxideshop', 'source', 'bootstrap.php']),
        ];
        if (($customPathToBootstrap = getenv('BOOTSTRAP_PATH')) !== false) {
            array_unshift($possiblePathsForBootstrap, $customPathToBootstrap);
        }
        foreach ($possiblePathsForBootstrap as $fileToRequire) {
            if (file_exists($fileToRequire)) {
                require_once $fileToRequire;
                break;
            }
        }
        if (!defined('VENDOR_PATH')) {
            $message = "Unable to locate valid 'bootstrap.php' in order to load OXID eShop framework.\n";
            $message .= "Please specify 'BOOTSTRAP_PATH' as environmental variable to use it directly.\n";
            throw new RuntimeException($message);
        }
    }
}
