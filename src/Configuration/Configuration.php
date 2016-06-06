<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\Configuration;

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
            return $this->getMultiCsFile()[self::FIXER_LEVELS];
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
}
