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
     * @param string $classNameParts
     *
     * @return string
     */
    private function removeSniffSuffix($classNameParts)
    {
        return substr(implode($classNameParts, '.'), 0, -5);
    }
}
