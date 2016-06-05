<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\Contract\CodeSniffer;

use PHP_CodeSniffer;

interface CodeSnifferFactoryInterface
{
    /**
     * @return PHP_CodeSniffer
     */
    public function create();
}
