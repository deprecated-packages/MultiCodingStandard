<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\PhpCsFixer\FileSystem;

use ReflectionClass;
use Symfony\Component\Finder\Finder;
use Symfony\CS\Fixer;

final class FixerFileSystem
{
    /**
     * @return string[]
     */
    public function findAllFixers() : array
    {
        $phpCsFixerReflection = new ReflectionClass(Fixer::class);
        $directoryWithFixers = dirname($phpCsFixerReflection->getFileName()) . '/Fixer';

        $finder = Finder::create()
            ->files()
            ->in($directoryWithFixers);

        return iterator_to_array($finder);
    }
}
