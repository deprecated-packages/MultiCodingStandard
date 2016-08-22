<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\PhpCsFixer\Application;

use Symplify\MultiCodingStandard\PhpCsFixer\Application\Command\RunApplicationCommand;

final class Application
{
    public function runCommand(RunApplicationCommand $command)
    {
        // resolve configuration
        dump($command);
        die;
    }
}
