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
     * @var string
     */
    const STANDARDS = 'standards';

    /**
     * @var string
     */
    const SNIFFS = 'sniffs';
    
    /**
     * @var string
     */
    const EXCLUDED_SNIFFS = 'exclude-sniffs';
    
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
        $this->ensureMultiJsFileIsLoaded();

        if (isset($this->multiCsFile[self::SNIFFS])) {
            return $this->normalizeSniffsFromClassesToUnderscoreLowercase($this->multiCsFile[self::SNIFFS]);
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getActiveStandards()
    {
        $this->ensureMultiJsFileIsLoaded();

        if (isset($this->multiCsFile[self::STANDARDS])) {
            return $this->multiCsFile[self::STANDARDS];
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getExcludedSniffs()
    {
        $this->ensureMultiJsFileIsLoaded();

        if (isset($this->multiCsFile[self::EXCLUDED_SNIFFS])) {
            return $this->multiCsFile[self::EXCLUDED_SNIFFS];
        }

        return [];
    }

    /**
     * @return string[]
     */
    private function normalizeSniffsFromClassesToUnderscoreLowercase(array $sniffs)
    {
        return $this->sniffNaming->detectUnderscoreLowercaseFromSniffClasses($sniffs);
    }

    private function ensureMultiJsFileIsLoaded()
    {
        if ($this->multiCsFile === null) {
            $this->multiCsFile = $this->multiCsFileLoader->load();
        }
    }
}
