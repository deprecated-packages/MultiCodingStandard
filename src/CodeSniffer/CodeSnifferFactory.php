<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\CodeSniffer;

use PHP_CodeSniffer;
use Symplify\MultiCodingStandard\Contract\CodeSniffer\CodeSnifferFactoryInterface;
use Symplify\MultiCodingStandard\Contract\CodeSniffer\FileSystem\RulesetFileSystemInterface;
use Symplify\MultiCodingStandard\Contract\CodeSniffer\FileSystem\SniffFileSystemInterface;
use Symplify\MultiCodingStandard\Contract\CodeSniffer\Naming\SniffNamingInterface;
use Symplify\MultiCodingStandard\Contract\Configuration\ConfigurationInterface;

final class CodeSnifferFactory implements CodeSnifferFactoryInterface
{
    /**
     * @var ConfigurationInterface
     */
    private $configuration;

    /**
     * @var SniffFileSystemInterface
     */
    private $sniffFileSystem;

    /**
     * @var RulesetFileSystemInterface
     */
    private $rulesetFileSystem;

    /**
     * @var SniffNamingInterface
     */
    private $sniffNaming;

    /**
     * @var PHP_CodeSniffer
     */
    private $codeSniffer;

    public function __construct(
        ConfigurationInterface $configuration,
        SniffFileSystemInterface $sniffFileSystem,
        SniffNamingInterface $sniffNaming,
        RulesetFileSystemInterface $rulesetFileSystem
    ) {
        $this->configuration = $configuration;
        $this->sniffFileSystem = $sniffFileSystem;
        $this->sniffNaming = $sniffNaming;
        $this->rulesetFileSystem = $rulesetFileSystem;
    }

    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $this->codeSniffer = new PHP_CodeSniffer();
        $this->setupSniffs($this->configuration->getActiveSniffs());
        $this->setupStandards($this->configuration->getActiveStandards());
        $this->setupErrorRecoding();

        return $this->codeSniffer;
    }

    private function setupSniffs(array $sniffs)
    {
        $this->codeSniffer->registerSniffs($this->sniffFileSystem->findAllSniffs(), $sniffs);
        $this->codeSniffer->populateTokenListeners();
    }

    private function setupStandards(array $standards)
    {
        foreach ($standards as $standard) {
            $rulesetPath = $this->rulesetFileSystem->getRulesetPathForStandardName($standard);
            $sniffFilePaths = $this->codeSniffer->processRuleset($rulesetPath);
            $sniffFilePaths = $this->removeExcludedSniffs($sniffFilePaths);
            $this->codeSniffer->registerSniffs($sniffFilePaths, []);
        }
    }

    private function setupErrorRecoding()
    {
        $this->codeSniffer->cli->setCommandLineValues([
            '-s', // showSources must be on, so that errors are recorded
        ]);
    }

    /**
     * @param string[] $sniffFilePaths
     * @return string[]
     */
    private function removeExcludedSniffs(array $sniffFilePaths)
    {
        $sniffFilePaths = $this->sniffNaming->detectDottedFromFilePaths($sniffFilePaths);
        foreach ($sniffFilePaths as $dottedName => $filePath) {
            if (in_array($dottedName, $this->configuration->getExcludedSniffs())) {
                unset($sniffFilePaths[$dottedName]);
            }
        }

        return $sniffFilePaths;
    }
}
