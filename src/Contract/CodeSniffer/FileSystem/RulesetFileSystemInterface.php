<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\Contract\CodeSniffer\FileSystem;

interface RulesetFileSystemInterface
{
    /**
     * @param string $standardName
     * @return string
     */
    public function getRulesetPathForStandardName($standardName);
}
