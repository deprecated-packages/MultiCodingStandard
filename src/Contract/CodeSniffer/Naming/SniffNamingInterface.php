<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\Contract\CodeSniffer\Naming;

interface SniffNamingInterface
{
    /**
     * @return string[]
     */
    public function detectUnderscoreLowercaseFromSniffClasses(array $sniffClasses);

    /**
     * @return string[]
     */
    public function detectDottedFromFilePaths(array $sniffFilePaths);
}
