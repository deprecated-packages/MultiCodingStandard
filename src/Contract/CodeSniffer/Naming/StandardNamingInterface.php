<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\Contract\CodeSniffer\Naming;

interface StandardNamingInterface
{
    /**
     * @param string $sniffClass
     * @return string
     */
    public function detectStandardNameFromSniffClassName($sniffClass);

    /**
     * @param string $sniffName
     * @return string
     */
    public function detectStandardNameFromSniffName($sniffName);
}