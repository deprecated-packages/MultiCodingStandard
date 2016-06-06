<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\PhpCsFixer;

use ReflectionClass;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\CS\Config\Config;
use Symfony\CS\ConfigurationResolver;
use Symfony\CS\Fixer;
use Symfony\CS\FixerInterface;
use Symplify\MultiCodingStandard\Contract\Configuration\ConfigurationInterface;

final class PhpCsFixerFactory
{
    /**
     * @var ConfigurationInterface
     */
    private $configuration;

    public function __construct(ConfigurationInterface $configuration)
    {
        $this->configuration = $configuration;
    }
    
    /**
     * @return Fixer
     */
    public function create()
    {
        // 1. find fixers classes
        $allFixerFiles = $this->getAllFixerFiles();
        $allFixerObjects = $this->createObjectsFromFixerFiles(iterator_to_array($allFixerFiles));

        $configurationResolver = new ConfigurationResolver();
        $configurationResolver->setAllFixers($allFixerObjects);

        // 2. filter fixers in by level
        $finalFiltersToBeRegistered = [];

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

            $finalFiltersToBeRegistered += $currentConfigurationResolver->getFixers();
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

            $finalFiltersToBeRegistered = array_merge(
                $finalFiltersToBeRegistered,
                $currentConfigurationResolver->getFixers()
            );
        }

        // 4. register final filters
        $phpCsFixer = new Fixer();
        $phpCsFixer->registerCustomFixers($finalFiltersToBeRegistered);

        return $phpCsFixer;
    }

    /**
     * @return Finder|SplFileInfo[]
     */
    private function getAllFixerFiles()
    {
        $phpCsFixerReflection = new ReflectionClass(Fixer::class);
        $directoryWithFixers = dirname($phpCsFixerReflection->getFileName()) . '/Fixer';

        return Finder::create()
            ->files()
            ->in($directoryWithFixers);
    }

    /**
     * @return object[]
     */
    private function createObjectsFromFixerFiles(array $fixerFiles)
    {
        $fixerObjects = [];
        foreach ($fixerFiles as $file) {
            $relativeNamespace = $file->getRelativePath();
            $class = 'Symfony\\CS\\Fixer\\' . ($relativeNamespace ? $relativeNamespace . '\\' : '') . $file->getBasename('.php');
            $fixerObjects[] = new $class;
        }

        return $fixerObjects;
    }
}
