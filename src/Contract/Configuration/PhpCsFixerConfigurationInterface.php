<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\Contract\Configuration;

interface PhpCsFixerConfigurationInterface
{
    /**
     * @var string
     */
    const FIXERS = 'fixers';

    /**
     * @var string
     */
    const EXCLUDED_FIXERS = 'exclude-fixers';

    /**
     * @var string
     */
    const FIXER_LEVELS = 'fixer-levels';
    
    /**
     * @return string[]
     */
    public function getActiveFixers();

    /**
     * @return string[]
     */
    public function getExcludedFixers();

    /**
     * @return string[]
     */
    public function getActiveFixerLevels();
}
