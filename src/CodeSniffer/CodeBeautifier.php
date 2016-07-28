<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\CodeSniffer;

use PHP_CodeSniffer;

final class CodeBeautifier extends PHP_CodeSniffer
{
    // fixers are only run where PHP_CODESNIFFER_INTERACTIVE = TRUE, WTF?
//    public function processFile($file, $contents = null)
//    {
//        $phpCsFile = parent::processFile($file, $contents);
//        //$file->fixer->enabled = true;
//        $phpCsFile->fixer->fixFile();
//        $phpCsFile->fixer->generateDiff(null, false);
//
//        $file = parent::processFile($file, $contents);
//
//        return $file;
//    }
}
