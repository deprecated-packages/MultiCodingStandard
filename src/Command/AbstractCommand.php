<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

abstract class AbstractCommand extends Command
{
    /**
     * @var int
     */
    const EXIT_CODE_SUCCESS = 0;

    /**
     * @var int
     */
    const EXIT_CODE_ERROR = 1;

    /**
     * @var int
     */
    protected $exitCode = self::EXIT_CODE_SUCCESS;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->addArgument('path', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'The path(s)', null);
    }
}
