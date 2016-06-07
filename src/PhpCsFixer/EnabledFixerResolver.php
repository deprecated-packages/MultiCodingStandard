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
        $configurationResolver = $this->configurationResolverFactory->create();

        // 2. filter fixers in by level
        $finalFixersToBeRegistered = [];

        // filter out custom ones
        $excludedFixers = '';
        if (count($this->configuration->getExcludedFixers())) {
            $excludedFixers .= '-'.implode(',-', $this->configuration->getExcludedFixers());
        }

        foreach ($this->configuration->getActiveFixerLevels() as $level) {
            $currentConfigurationResolver = clone $configurationResolver;
            if ($excludedFixers) {
                $currentConfigurationResolver->setOption('fixers', $excludedFixers);
            }
            $currentConfigurationResolver->setOption('level', $level);
            $currentConfigurationResolver->resolve();

            $finalFixersToBeRegistered += $currentConfigurationResolver->getFixers();
        }

        // 3. filter in custom ones
        $fixers = '';
        if (count($this->configuration->getActiveFixers())) {
            $fixers .= implode(',', $this->configuration->getActiveFixers());
        }

        if ($fixers) {
            $currentConfigurationResolver = clone $configurationResolver;
            $currentConfigurationResolver->setOption('level', 'none');
            $currentConfigurationResolver->setOption('fixers', $fixers);
            $currentConfigurationResolver->resolve();

            $finalFixersToBeRegistered = array_merge(
                $finalFixersToBeRegistered,
                $currentConfigurationResolver->getFixers()
            );
        }
        
        return $finalFixersToBeRegistered;
    }

}