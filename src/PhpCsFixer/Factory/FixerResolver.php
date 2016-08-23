<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\PhpCsFixer\Factory;

use Symfony\CS\ConfigurationResolver;

final class FixerResolver
{
    /**
     * @var ConfigurationResolver
     */
    private $configurationResolver;

    public function __construct(ConfigurationResolver $configurationResolver)
    {
        $this->configurationResolver = $configurationResolver;
    }

    public function resolveFixersByLevelAndExcludedFixers(array $fixerLevels, array $excludedFixers) : array
    {
        if (!count($fixerLevels)) {
            return [];
        }

        $fixers = [];
        foreach ($fixerLevels as $fixerLevel) {
            $currentConfigurationResolver = clone $this->configurationResolver;

            $excludedFixersAsString = $this->turnExcludedFixersToString($excludedFixers);
            $currentConfigurationResolver->setOption('level', $fixerLevel);
            $currentConfigurationResolver->setOption('fixers', $excludedFixersAsString);
            $currentConfigurationResolver->resolve();

            $fixers = array_merge($fixers, $currentConfigurationResolver->getFixers());
        }

        return $fixers;
    }

    public function resolveFixers(array $fixers) : array
    {
        if (!count($fixers)) {
            return [];
        }

        $fixersAsString = $this->turnFixersToString($fixers);

        $currentConfigurationResolver = clone $this->configurationResolver;
        $currentConfigurationResolver->setOption('level', 'none');
        $currentConfigurationResolver->setOption('fixers', $fixersAsString);
        $currentConfigurationResolver->resolve();

        return $currentConfigurationResolver->getFixers();
    }

    private function turnFixersToString(array $fixers) : string
    {
        return $this->implodeWithPresign($fixers);
    }

    private function turnExcludedFixersToString(array $excludedFixers) : string
    {
        return $this->implodeWithPresign($excludedFixers, '-');
    }

    private function implodeWithPresign(array $items, string $presign = '')
    {
        if (count($items)) {
            return $presign . implode(',' . $presign, $items);
        }
        return '';

    }
}
