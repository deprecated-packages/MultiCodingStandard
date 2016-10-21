<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\DI;

use Nette\DI\CompilerExtension;
use Nette\DI\Helpers;

final class MultiCodingStandardExtension extends CompilerExtension
{
    /**
     * @var string[]
     */
    private $defaults = [
        'configPathsToCheck' => [
            '%appDir%/../../../../multi-cs.json', # installed as dependency
            '%appDir%/../../multi-cs.json', # cloned package
        ]
    ];

    public function loadConfiguration()
    {
        $this->setConfigToContainerBuilder($this->defaults);
        $this->loadServicesFromConfigPath(__DIR__ . '/../config/services.neon');
    }

    /**
     * @param string[] $defaults
     */
    private function setConfigToContainerBuilder(array $defaults)
    {
        $config = $this->validateConfig($defaults);
        $config['configPath'] = $this->detectConfigPath($config['configPathsToCheck']);
        $this->getContainerBuilder()->parameters += $config;
    }

    private function loadServicesFromConfigPath(string $configPath)
    {
        $containerBuilder = $this->getContainerBuilder();
        $config = $this->loadFromFile($configPath);
        $this->compiler->parseServices($containerBuilder, $config);
    }

    private function detectConfigPath(array $configPathsToCheck) : string
    {
        foreach ($configPathsToCheck as $configPathToCheck) {
            $configPath = Helpers::expand($configPathToCheck, $this->getContainerBuilder()->parameters);
            if (file_exists($configPath)) {
                return $configPath;
            }
        }

        return '';
    }
}
