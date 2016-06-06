<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\CodeSniffer\Naming;

use Nette\Utils\Strings;
use Symplify\MultiCodingStandard\Contract\CodeSniffer\Naming\SniffNamingInterface;

final class SniffNaming implements SniffNamingInterface
{
    /**
     * {@inheritdoc}
     */
    public function detectUnderscoreLowercaseFromSniffClassesOrNames(array $sniffClassesOrNames)
    {
        $underscoreLowercaseNames = [];
        foreach ($sniffClassesOrNames as $sniffClassOrName) {
            if (Strings::contains($sniffClassOrName, '.')) {
                $sniffNameParts = explode('.', $sniffClassOrName);
                array_splice($sniffNameParts, 1, 0, ['Sniffs']);
                $sniffNameParts[3] .= 'Sniff';
                $underscoreName = implode('_', $sniffNameParts);
            } else {
                $underscoreName = str_replace(['\\'], ['_'], $sniffClassOrName);
            }

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
