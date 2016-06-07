<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\PhpCsFixer;

use Symfony\CS\ConfigurationResolver;
use Symfony\CS\Fixer;
use Symfony\CS\FixerInterface;
use Symplify\MultiCodingStandard\Contract\Configuration\PhpCsFixerConfigurationInterface;

final class EnabledFixerResolver
{
    /**
     * @var PhpCsFixerConfigurationInterface
     */
    private $configuration;

    /**
     * @var ConfigurationResolverFactory
     */
    private $configurationResolverFactory;

    /**
     * @var FixerInterface[]
     */
    private $enabledFixers = [];

    public function __construct(
        PhpCsFixerConfigurationInterface $configuration,
        ConfigurationResolverFactory $configurationResolverFactory
    ) {
        $this->configuration = $configuration;
        $this->configurationResolverFactory = $configurationResolverFactory;
    }
    
    /**
     * @return FixerInterface[]
     */
    public function getEnabledFixers()
    {
        if ($this->enabledFixers !== []) {
            return $this->enabledFixers;
        }

        $configurationResolver = $this->configurationResolverFactory->create();

        $this->addFixersByLevel($configurationResolver);
        $this->addCustomFixers($configurationResolver);

        return $this->enabledFixers;
    }

    private function addFixersByLevel(ConfigurationResolver $configurationResolver)
    {
        $excludedFixers = $this->getExcludedFixersAsString();
        foreach ($this->configuration->getActiveFixerLevels() as $level) {
            $currentConfigurationResolver = clone $configurationResolver;
            if ($excludedFixers) {
                $currentConfigurationResolver->setOption('fixers', $excludedFixers);
            }
            $currentConfigurationResolver->setOption('level', $level);
            $currentConfigurationResolver->resolve();

            $this->enabledFixers = array_merge($this->enabledFixers, $currentConfigurationResolver->getFixers());
        }
    }

    /**
     * @return string
     */
    private function getExcludedFixersAsString()
    {
        $excludedFixers = '';
        if (count($this->configuration->getExcludedFixers())) {
            $excludedFixers .= '-' . implode(',-', $this->configuration->getExcludedFixers());
            return $excludedFixers;
        }
        return $excludedFixers;
    }

    /**
     * @return array
     */
    private function addCustomFixers(ConfigurationResolver $configurationResolver)
    {
        $fixers = $this->getEnabledFixersAsString();

        if ($fixers) {
            $currentConfigurationResolver = clone $configurationResolver;
            $currentConfigurationResolver->setOption('level', 'none');
            $currentConfigurationResolver->setOption('fixers', $fixers);
            $currentConfigurationResolver->resolve();

            $this->enabledFixers = array_merge($this->enabledFixers, $currentConfigurationResolver->getFixers());
        }
    }

    /**
     * @return string
     */
    private function getEnabledFixersAsString()
    {
        $fixers = '';
        if (count($this->configuration->getActiveFixers())) {
            $fixers .= implode(',', $this->configuration->getActiveFixers());
            return $fixers;
        }
        return $fixers;
    }
}
