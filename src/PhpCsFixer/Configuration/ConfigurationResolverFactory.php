<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\PhpCsFixer\Configuration;

use Symfony\CS\ConfigurationResolver;
use Symfony\CS\Fixer;
use Symfony\CS\FixerInterface;

final class ConfigurationResolverFactory
{
    public function create() : ConfigurationResolver
    {
        $configurationResolver = new ConfigurationResolver();
        $configurationResolver->setAllFixers($this->getAllFixers());
        return $configurationResolver;
    }

    /**
     * @return FixerInterface[]
     */
    private function getAllFixers() : array
    {
        $fixer = new Fixer();
        $fixer->registerBuiltInFixers();
        return $fixer->getFixers();
    }
}
