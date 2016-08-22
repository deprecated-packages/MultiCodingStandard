<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\PhpCsFixer;

use Symfony\CS\Fixer;

final class PhpCsFixerFactory
{
    /**
     * @var EnabledFixerResolver
     */
    private $enabledFixerResolver;

    public function __construct(EnabledFixerResolver $enabledFixerResolver)
    {
        $this->enabledFixerResolver = $enabledFixerResolver;
    }
    
    public function create() : Fixer
    {
        $phpCsFixer = new Fixer();
        $phpCsFixer->registerCustomFixers(
            $this->enabledFixerResolver->getEnabledFixers()
        );

        return $phpCsFixer;
    }
}
