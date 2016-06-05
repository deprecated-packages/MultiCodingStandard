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
     * @var null|array
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
        if ($this->multiCsFile === null) {
            $this->multiCsFile = $this->multiCsFileLoader->load();
        }

        if (isset($this->multiCsFile['sniffs'])) {
            return $this->normalizeSniffsFromClassesToUnderscoreLowercase($this->multiCsFile['sniffs']);
            // return $this->normalizeSniffsFromClassesToNames($this->multiCsFile['sniffs']);
        }
        
        return [];
    }

    /**
     * @return array
     */
    private function normalizeSniffsFromClassesToNames(array $sniffs)
    {
        return $this->sniffNaming->detectSniffNameFromSniffClasses($sniffs);
    }

    /**
     * @return string[]
     */
    private function normalizeSniffsFromClassesToUnderscoreLowercase(array $sniffs)
    {
        return $this->sniffNaming->detectUnderscoreLowercaseFromSniffClasses($sniffs);
    }
}
