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
        'configPath' => '%appDir%/../../multi-cs.json'
    ];

    /**
     * {@inheritdoc}
     */
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
        $config['configPath'] = Helpers::expand($config['configPath'], $this->getContainerBuilder()->parameters);
        $this->getContainerBuilder()->parameters += $config;
    }

    private function loadServicesFromConfigPath(string $configPath)
    {
        $containerBuilder = $this->getContainerBuilder();
        $config = $this->loadFromFile($configPath);
        $this->compiler->parseServices($containerBuilder, $config);
    }
}
