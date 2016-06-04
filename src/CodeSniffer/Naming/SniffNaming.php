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
    public function detectSniffNameFromSniffClasses(array $sniffClasses)
    {
        $sniffNames = [];
        foreach ($sniffClasses as $sniffClass) {
            $classNameParts = explode('\\', $sniffClass);
            unset($classNameParts[1]);

            $sniffNames[] = $this->removeSniffSuffix($classNameParts);
        }

        return $sniffNames;
    }

    /**
     * @param string $classNameParts
     * @return string
     */
    private function removeSniffSuffix($classNameParts)
    {
        $sniffName = substr(implode($classNameParts, '.'), 0, -5);
        return $sniffName;
    }
}
