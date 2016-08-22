<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\CodeSniffer\Legacy;

use Symplify\PHP7_CodeSniffer\Composer\VendorDirProvider;
use Symplify\PHP7_CodeSniffer\Sniff\Finder\SniffClassFilter;
use Symplify\PHP7_CodeSniffer\Sniff\Finder\SniffClassRobotLoaderFactory;
use Symplify\PHP7_CodeSniffer\Sniff\Finder\SniffFinder;

/**
 * @todo Move to PHP7_CodeSniffer
 */
final class Version2ClassAliases
{
    public static function register()
    {
        $sniffFinder = new SniffFinder(
            new SniffClassRobotLoaderFactory(),
            new SniffClassFilter()
        );

        $sniffClasses = $sniffFinder->findAllSniffClassesInDirectory(VendorDirProvider::provide() . '/squizlabs/php_codesniffer/src/Standards');
        foreach ($sniffClasses as $sniffCode => $sniffClass) {
            $legacySniffClass = self::convertSniffCodeToLegacyClassName($sniffCode);
            class_alias($sniffClass, $legacySniffClass);
        }

        // abstract sniffs
        class_alias('PHP_CodeSniffer\Sniffs\AbstractVariableSniff', 'PHP_CodeSniffer_Standards_AbstractVariableSniff');
    }

    private static function convertSniffCodeToLegacyClassName(string $sniffCode) : string
    {
        $parts = explode('.', $sniffCode);
        return $parts[0] . '_Sniffs_' . $parts[1] . '_' . $parts[2] . 'Sniff';
    }
}
