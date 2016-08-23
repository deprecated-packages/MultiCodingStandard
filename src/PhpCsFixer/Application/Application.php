<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\PhpCsFixer\Application;

use Symfony\CS\Fixer;
use Symplify\MultiCodingStandard\PhpCsFixer\Application\Command\RunApplicationCommand;
use Symplify\MultiCodingStandard\PhpCsFixer\Factory\FixerSetFactory;

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

    public function __construct(Fixer $fixer, FixerSetFactory $fixerSetFactory)
    {
        $this->fixer = $fixer;
        $this->fixerSetFactory = $fixerSetFactory;
    }

    public function runCommand(RunApplicationCommand $command)
    {
        $fixers = $this->fixerSetFactory->createFromLevelsFixersAndExcludedFixers(
            $command->getFixerLevels(),
            $command->getFixers(),
            $command->getExcludeFixers()
        );

        $this->fixer->registerCustomFixers($fixers);
    }
}
