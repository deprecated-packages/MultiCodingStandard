<?php

declare(strict_types=1);

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\PhpCsFixer\Factory;

use Symfony\CS\ConfigurationResolver;
use Symfony\CS\FixerInterface;

final class FixerFactory
{
    /**
     * @var ConfigurationResolver
     */
    private $configurationResolver;

    public function __construct(ConfigurationResolver $configurationResolver)
    {
        $this->configurationResolver = $configurationResolver;
    }

    /**
     * @return FixerInterface[]
     */
    public function createFromLevelsFixersAndExcludedFixers(array $fixerLevels, array $fixers, array $excludedFixers) : array
    {
        $fixersFromLevels = $this->createFromLevelsAndExcludedFixers($fixerLevels, $excludedFixers);
        $standaloneFixers = $this->createFromFixers($fixers);

        return array_merge($fixersFromLevels, $standaloneFixers);
    }

    private function createFromLevelsAndExcludedFixers(array $fixerLevels, array $excludedFixers) : array
    {
        if (!count($fixerLevels)) {
            return [];
        }

        $fixers = [];
        foreach ($fixerLevels as $fixerLevel) {
            $excludedFixersAsString = $this->turnExcludedFixersToString($excludedFixers);
            $newFixers = $this->resolveFixersForLevelsAndFixers($fixerLevel, $excludedFixersAsString);

            $fixers = array_merge($fixers, $newFixers);
        }

        return $fixers;
    }

    private function createFromFixers(array $fixers) : array
    {
        if (!count($fixers)) {
            return [];
        }

        $fixersAsString = $this->turnFixersToString($fixers);
        return $this->resolveFixersForLevelsAndFixers('none', $fixersAsString);
    }

    private function resolveFixersForLevelsAndFixers(string $level, string $fixersAsString) : array
    {
        $currentConfigurationResolver = clone $this->configurationResolver;
        $currentConfigurationResolver->setOption('level', $level);
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
