<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\CodeSniffer\FileSystem;

use Nette\Utils\Strings;
use Symfony\Component\Finder\Finder;
use Symplify\MultiCodingStandard\Contract\CodeSniffer\FileSystem\RulesetFileSystemInterface;

final class RulesetFileSystem implements RulesetFileSystemInterface
{
    /**
     * @var string
     */
    private $vendorDir;

    /**
     * @param string $vendorDir
     */
    public function __construct($vendorDir)
    {
        $this->vendorDir = $vendorDir;
    }

    /**
     * {@inheritdoc}
     */
    public function getRulesetPathForStandardName($standardName)
    {
        $installedStandards = (new Finder())->in($this->vendorDir)
            ->path('ruleset.xml')
            ->files();

        $standardRulesets = array_keys(iterator_to_array($installedStandards));

        foreach ($standardRulesets as $standardRuleset) {
            if (Strings::contains($standardRuleset, $standardName)) {
                return $standardRuleset;
            }
        }
    }
}
