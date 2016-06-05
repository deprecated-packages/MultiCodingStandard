<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\CodeSniffer\Naming;

use Symplify\MultiCodingStandard\Contract\CodeSniffer\Naming\SniffNamingInterface;

final class SniffNaming implements SniffNamingInterface
{
    /**
     * {@inheritdoc}
     */
    public function detectUnderscoreLowercaseFromSniffClasses(array $sniffClasses)
    {
        $underscoreLowercaseNames = [];
        foreach ($sniffClasses as $sniffClass) {
            $classNameParts = explode('\\', $sniffClass);
            $underscoreName = implode($classNameParts, '_');

            $underscoreLowercaseNames[] = strtolower($underscoreName);
        }

        return $underscoreLowercaseNames;
    }

    /**
     * {@inheritdoc}
     */
    public function detectDottedFromFilePaths(array $sniffFilePaths)
    {
        $dottedNames = [];
        foreach ($sniffFilePaths as $sniffFilePath) {
            $sniffFilePathParts = explode(DIRECTORY_SEPARATOR, $sniffFilePath);
            $sniffFilePathParts = array_slice($sniffFilePathParts, -4);
            
            unset($sniffFilePathParts[1]); // drop "/Sniffs" 
            $sniffFilePathParts[3] = substr($sniffFilePathParts[3], 0, -9); // drop "Sniff.php"

            $dottedName = implode($sniffFilePathParts, '.');

            $dottedNames[$dottedName] = $sniffFilePath;
        }

        return $dottedNames;
    }
}
