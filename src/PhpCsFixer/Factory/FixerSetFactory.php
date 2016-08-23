<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\PhpCsFixer\Factory;

use Symfony\CS\Fixer;
use Symfony\CS\FixerInterface;
use Symplify\PHP7_CodeSniffer\Configuration\ConfigurationResolver;

final class FixerSetFactory
{
    /**
     * @var FixerResolver
     */
    private $fixerResolver;

    public function __construct(FixerResolver $fixerResolver)
    {
        $this->fixerResolver = $fixerResolver;
    }

    /**
     * @return FixerInterface[]
     */
    public function createFromLevelsFixersAndExcludedFixers(array $fixerLevels, array $fixers, array $excludedFixers) : array
    {
        $fixersFromLevels = $this->fixerResolver->resolveFixersByLevelAndExcludedFixers($fixerLevels, $excludedFixers);
        $standaloneFixers = $this->fixerResolver->resolveFixers($fixers);

        $allFixers = array_merge($fixersFromLevels, $standaloneFixers);
        dump(count($allFixers));
        die;
    }
}
