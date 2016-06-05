<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\DI;

use Nette\DI\CompilerExtension;
use Nette\DI\ServiceDefinition;
use Symfony\Component\Console\Command\Command;
use Symplify\MultiCodingStandard\Console\Application;

final class MultiCodingStandardExtension extends CompilerExtension
{
    /**
     * @var string[]
     */
    private $defaults = [
        'configPath' => '%appDir%/../multi-cs.json'
        # %appDir%/../multi-cs.json
    ];

    /**
     * {@inheritdoc}
     */
    public function loadConfiguration()
    {
        $config = $this->validateConfig($this->defaults);
        $this->getContainerBuilder()->parameters += $config;

        $this->loadServicesFromConfig();
    }

    /**
     * {@inheritdoc}
     */
    public function beforeCompile()
    {
        $this->loadCommandsToConsoleApplication();
    }

    private function loadServicesFromConfig()
    {
        $containerBuilder = $this->getContainerBuilder();
        $config = $this->loadFromFile(__DIR__.'/../config/services.neon');
        $this->compiler->parseServices($containerBuilder, $config);
    }

    private function loadCommandsToConsoleApplication()
    {
        $consoleApplication = $this->getDefinitionByType(Application::class);

        $containerBuilder = $this->getContainerBuilder();
        foreach ($containerBuilder->findByType(Command::class) as $definition) {
            $consoleApplication->addSetup('add', ['@'.$definition->getClass()]);
        }
    }

    /**
     * @param string $type
     *
     * @return ServiceDefinition
     */
    private function getDefinitionByType($type)
    {
        $containerBuilder = $this->getContainerBuilder();
        $definitionName = $containerBuilder->getByType($type);

        return $containerBuilder->getDefinition($definitionName);
    }
}
