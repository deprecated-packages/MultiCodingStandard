<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\CodeSniffer\FileSystem;

use Exception;
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
     * @var strings[]
     */
    private $rulesets = [];

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
        if (isset($this->getRulesets()[$standardName])) {
            return $this->getRulesets()[$standardName];
        }

        throw new Exception(
            sprintf(
                'Ruleset for standard "%s" was not found. Found standards are: %s.',
                $standardName,
                implode($this->getRulesetNames(), ', ')
            )
        );
    }

    /**
     * @return array
     */
    private function getRulesets()
    {
        if ($this->rulesets) {
            return $this->rulesets;
        }

        foreach ($this->findRulesetFiles() as $rulesetFile) {
            $rulesetXml = simplexml_load_file($rulesetFile);

            $rulesetName = (string) $rulesetXml['name'];
            $this->rulesets[$rulesetName] = $rulesetFile;
        }

        return $this->rulesets;
    }

    /**
     * @return string[]
     */
    private function findRulesetFiles()
    {
        $installedStandards = (new Finder())->files()
            ->in($this->vendorDir)
            ->name('ruleset.xml');

        return array_keys(iterator_to_array($installedStandards));
    }

    /**
     * @return string[]
     */
    private function getRulesetNames()
    {
        return array_keys($this->getRulesets());
    }
}
