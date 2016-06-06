<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\Configuration;

use Symfony\CS\FixerInterface;
use Symplify\MultiCodingStandard\Contract\CodeSniffer\Naming\SniffNamingInterface;
use Symplify\MultiCodingStandard\Contract\Configuration\ConfigurationInterface;
use Symplify\MultiCodingStandard\Contract\Configuration\MultiCsFileLoaderInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * @var MultiCsFileLoaderInterface
     */
    private $multiCsFileLoader;

    /**
     * @var SniffNamingInterface
     */
    private $sniffNaming;

    /**
     * @var array
     */
    private $multiCsFile;

    public function __construct(MultiCsFileLoaderInterface $multiCsFileLoader, SniffNamingInterface $sniffNaming)
    {
        $this->multiCsFileLoader = $multiCsFileLoader;
        $this->sniffNaming = $sniffNaming;
    }

    /**
     * {@inheritdoc}
     */
    public function getActiveSniffs()
    {
        if (isset($this->getMultiCsFile()[self::SNIFFS])) {
            $sniffs = $this->getMultiCsFile()[self::SNIFFS];
            return $this->sniffNaming->detectUnderscoreLowercaseFromSniffClassesOrNames($sniffs);
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getActiveStandards()
    {
        if (isset($this->getMultiCsFile()[self::STANDARDS])) {
            return $this->getMultiCsFile()[self::STANDARDS];
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getExcludedSniffs()
    {
        if (isset($this->getMultiCsFile()[self::EXCLUDED_SNIFFS])) {
            return $this->getMultiCsFile()[self::EXCLUDED_SNIFFS];
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getActiveFixers()
    {
        if (isset($this->getMultiCsFile()[self::FIXERS])) {
            return $this->getMultiCsFile()[self::FIXERS];
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getExcludedFixers()
    {
        if (isset($this->getMultiCsFile()[self::EXCLUDED_FIXERS])) {
            return $this->getMultiCsFile()[self::EXCLUDED_FIXERS];
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getActiveFixerLevels()
    {
        if (isset($this->getMultiCsFile()[self::FIXER_LEVELS])) {
            $fixerLevels = $this->getMultiCsFile()[self::FIXER_LEVELS];
            $this->ensureLevelsAreValid($fixerLevels);

            return $fixerLevels;
        }

        return [];
    }

    /**
     * @return array
     */
    private function getMultiCsFile()
    {
        if ($this->multiCsFile) {
            return $this->multiCsFile;
        }

        $this->multiCsFile = $this->multiCsFileLoader->load();

        return $this->multiCsFile;
    }

    /**
     * @return string[]
     */
    private function getFixerLevels()
    {
        return ['psr0', 'psr1', 'psr2', 'symfony'];
    }

    /**
     * @throws \Exception
     */
    private function ensureLevelsAreValid(array $fixerLevels)
    {
        foreach ($fixerLevels as $fixerLevel) {
            if (!in_array($fixerLevel, $this->getFixerLevels(), true)) {
                throw new \Exception(
                    sprintf(
                        'Level "%s" is not supported. Available levels are: %s.',
                        $fixerLevel,
                        implode($this->getFixerLevels(), ', ')
                    )
                );
            }
        }
    }
}
