<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\Contract\CodeSniffer;

use Symplify\MultiCodingStandard\CodeSniffer\CodeBeautifier;

interface CodeBeautifierFactoryInterface
{
    /**
     * @return CodeBeautifier
     */
    public function create();
}