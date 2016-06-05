<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\Contract\CodeSniffer\FileSystem;

interface SniffFileSystemInterface
{
    /**
     * @return string[]
     */
    public function findAllSniffs();
}
