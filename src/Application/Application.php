<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\Application;

use Symplify\MultiCodingStandard\Application\Command\RunApplicationCommand;
use Symplify\MultiCodingStandard\PhpCsFixer\Application\Application as PhpCsFixerApplication;
use Symplify\MultiCodingStandard\PhpCsFixer\Application\Command\RunApplicationCommand as PhpCsFixerRunApplicationCommand;
use Symplify\PHP7_CodeSniffer\Application\Application as Php7CodeSnifferApplication;
use Symplify\PHP7_CodeSniffer\Application\Command\RunApplicationCommand as Php7CodeSnifferRunApplicationCommand;

final class Application
{
    /**
     * @var Php7CodeSnifferApplication
     */
    private $php7CodeSnifferApplication;

    /**
     * @var PhpCsFixerApplication
     */
    private $phpCsFixerApplication;

    public function __construct(
        Php7CodeSnifferApplication $php7CodeSnifferApplication,
        PhpCsFixerApplication $phpCsFixerApplication
    ) {
        $this->php7CodeSnifferApplication = $php7CodeSnifferApplication;
        $this->phpCsFixerApplication = $phpCsFixerApplication;
    }

    public function runCommand(RunApplicationCommand $command)
    {
        $this->php7CodeSnifferApplication->runCommand(
            $this->createPhp7CodeSnifferRunApplicationCommand($command)
        );

        $this->phpCsFixerApplication->runCommand(
            $this->createPhpCsFixerRunApplicationCommand($command)
        );
    }

    private function createPhp7CodeSnifferRunApplicationCommand(RunApplicationCommand $command) : Php7CodeSnifferRunApplicationCommand
    {
        return new Php7CodeSnifferRunApplicationCommand(
            $command->getSource(),
            $command->getJsonConfiguration()['standards'] ?? [],
            $command->getJsonConfiguration()['sniffs'] ?? [],
            $command->getJsonConfiguration()['exclude-sniffs'] ?? [],
            $command->isFixer()
        );
    }

    private function createPhpCsFixerRunApplicationCommand(RunApplicationCommand $command) : PhpCsFixerRunApplicationCommand
    {
        return new PhpCsFixerRunApplicationCommand(
            $command->getSource(),
            $command->getJsonConfiguration()['fixer-levels'] ?? [],
            $command->getJsonConfiguration()['fixers'] ?? [],
            $command->getJsonConfiguration()['exclude-fixers'] ?? [],
            $command->isFixer()
        );
    }
}