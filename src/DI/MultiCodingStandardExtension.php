<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\DI;

use Nette\DI\CompilerExtension;
use Nette\DI\Helpers;
use Nette\DI\ServiceDefinition;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symplify\MultiCodingStandard\Console\MultiCodingStandardApplication;
use Symplify\PHP7_CodeSniffer\DI\ExtensionHelperTrait;

final class MultiCodingStandardExtension extends CompilerExtension
{
    use ExtensionHelperTrait;

    /**
     * @var string[]
     */
    private $defaults = [
        'configPath' => '%appDir%/../multi-cs.json'
    ];

    /**
     * {@inheritdoc}
     */
    public function loadConfiguration()
    {
        $this->setConfigToContainerBuilder($this->defaults);
        $this->loadServicesFromConfig();
    }

    /**
     * {@inheritdoc}
     */
    public function beforeCompile()
    {
        $this->loadCommandsToConsoleApplication();
        $this->loadEventSubscribersToEventDispatcher();
    }

    private function loadServicesFromConfig()
    {
        $containerBuilder = $this->getContainerBuilder();
        $config = $this->loadFromFile(__DIR__.'/../config/services.neon');
        $this->compiler->parseServices($containerBuilder, $config);
    }

    private function loadCommandsToConsoleApplication()
    {
        $this->addServicesToCollector(MultiCodingStandardApplication::class, Command::class, 'add');
    }

    private function loadEventSubscribersToEventDispatcher()
    {
        $this->addServicesToCollector(EventDispatcherInterface::class, EventSubscriberInterface::class, 'addSubscriber');
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
}
