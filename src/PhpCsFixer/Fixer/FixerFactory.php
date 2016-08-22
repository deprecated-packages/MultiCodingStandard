<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\PhpCsFixer\Fixer;

use Symfony\CS\FixerInterface;

final class FixerFactory
{
    /**
     * @param string[] $files
     * @return FixerInterface[]
     */
    public function createFixersFromFiles(array $files) : array
    {
        $fixers = [];
        foreach ($files as $file) {
            $relativeNamespace = $file->getRelativePath();
            $class = 'Symfony\\CS\\Fixer\\' . ($relativeNamespace ? $relativeNamespace . '\\' : '') . $file->getBasename('.php');
            $fixers[] = new $class;
        }

        return $fixers;
    }
}
