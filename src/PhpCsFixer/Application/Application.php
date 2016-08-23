<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\PhpCsFixer\Application;

use Symfony\CS\Config;
use Symfony\CS\Fixer;
use Symplify\MultiCodingStandard\PhpCsFixer\Application\Command\RunApplicationCommand;
use Symplify\MultiCodingStandard\PhpCsFixer\Factory\FixerSetFactory;
use Symplify\PHP7_CodeSniffer\File\Finder\SourceFinder;

final class Application
{
    /**
     * @var Fixer
     */
    private $fixer;

    /**
     * @var FixerSetFactory
     */
    private $fixerSetFactory;
    /**
     * @var SourceFinder
     */
    private $sourceFinder;

    public function __construct(Fixer $fixer, FixerSetFactory $fixerSetFactory, SourceFinder $sourceFinder)
    {
        $this->fixer = $fixer;
        $this->fixerSetFactory = $fixerSetFactory;
        $this->sourceFinder = $sourceFinder;
    }

    public function runCommand(RunApplicationCommand $command)
    {
        $this->registerFixersToFixer($command->getFixerLevels(), $command->getFixers(), $command->getExcludeFixers());

        $this->runForSource($command->getSource(), $command->isFixer());
    }

    private function registerFixersToFixer(array $fixerLevels, array $fixers, array $excludedFixers)
    {
        $fixers = $this->fixerSetFactory->createFromLevelsFixersAndExcludedFixers($fixerLevels, $fixers, $excludedFixers);
        $this->fixer->registerCustomFixers($fixers);
    }

    private function runForSource(array $source, bool $isFixer)
    {
//        $files = $this->sourceFinder->find($source);

        $config = new Config();
        $config->finder(new \ArrayIterator($source));
        $configs = $this->fixer->addConfig($config);

        foreach ($files as $splFileInfo) {
            $this->fixer->fixFile($splFileInfo, $this->fixer->getFixers(), !$isFixer);
        }
    }
}
