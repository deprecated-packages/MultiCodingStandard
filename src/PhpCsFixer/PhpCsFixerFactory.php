<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\PhpCsFixer;

use Symfony\CS\Fixer;
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
        $phpCsFixer = new Fixer();
        
        $this->configuration->getActiveFixerLevels();
        $this->configuration->getExcludedFixers();
        $this->configuration->getActiveFixers();

        return $phpCsFixer;
    }
}
