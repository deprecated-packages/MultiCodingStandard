<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\Contract\Configuration;

interface PhpCodeSnifferConfigurationInterface
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
     * @return string[]
     */
    public function getActiveSniffs();

    /**
     * @return string[]
     */
    public function getExcludedSniffs();

    /**
     * @return string[]
     */
    public function getActiveStandards();
}
