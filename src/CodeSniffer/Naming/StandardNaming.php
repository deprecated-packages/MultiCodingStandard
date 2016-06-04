<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\CodeSniffer\Naming;

use Exception;
use Nette\Utils\Strings;
use Symplify\MultiCodingStandard\Contract\CodeSniffer\Naming\StandardNamingInterface;

final class StandardNaming implements StandardNamingInterface
{
    /**
     * {@inheritdoc}
     */
    public function detectStandardNameFromSniffClassName($sniffClass)
    {
        $classNameParts = explode('\\', $sniffClass);
        $standardFullName = $classNameParts[0];

        if (Strings::endsWith($standardFullName, 'CodingStandard')) {
            return substr($standardFullName, 0, -14);
        }

        throw new Exception('Not supported yet.');
    }

    /**
     * {@inheritdoc}
     */
    public function detectStandardNameFromSniffName($sniffName)
    {
        $sniffNameParts = explode('.', $sniffName);
        $standardFullName = $sniffNameParts[0];

        if (Strings::endsWith($standardFullName, 'CodingStandard')) {
            return substr($standardFullName, 0, -14);
        }

        throw new Exception('Not supported yet.');
    }
}
