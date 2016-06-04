<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\CodeSniffer;

use PHP_CodeSniffer;
use Symplify\MultiCodingStandard\Contract\CodeSniffer\CodeSnifferFactoryInterface;
use Symplify\MultiCodingStandard\Contract\CodeSniffer\FileSystem\RulesetFileSystemInterface;
use Symplify\MultiCodingStandard\Contract\CodeSniffer\Naming\StandardNamingInterface;
use Symplify\MultiCodingStandard\Contract\Configuration\ConfigurationInterface;

final class CodeSnifferFactory implements CodeSnifferFactoryInterface
{
    /**
     * @var ConfigurationInterface
     */
    private $configuration;

    /**
     * @var StandardNamingInterface
     */
    private $standardNaming;

    /**
     * @var RulesetFileSystemInterface
     */
    private $rulesetFileSystem;

    public function __construct(
        ConfigurationInterface $configuration,
        StandardNamingInterface $standardNaming,
        RulesetFileSystemInterface $rulesetFileSystem
    ) {
        $this->configuration = $configuration;
        $this->standardNaming = $standardNaming;
        $this->rulesetFileSystem = $rulesetFileSystem;
    }

    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $codeSniffer = new PHP_CodeSniffer();
        $this->setupStandardsAndSniffs($codeSniffer);

        return $codeSniffer;
    }

    private function setupStandardsAndSniffs(PHP_CodeSniffer $codeSniffer)
    {
        foreach ($this->configuration->getActiveSniffs() as $sniffName) {
            $standardName = $this->standardNaming->detectStandardNameFromSniffName($sniffName);
            $standardRuleset = $this->rulesetFileSystem->getRulesetPathForStandardName($standardName);

            $codeSniffer->initStandard($standardRuleset, $this->configuration->getActiveSniffs());
        }
    }
}
