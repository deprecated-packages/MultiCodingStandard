<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\Contract\PhpCsFixer\FileSystem;

use Symfony\Component\Finder\SplFileInfo;

interface FixerFileSystemInterface
{
    /**
     * @return SplFileInfo[]
     */
    public function findAllFixers();
}
