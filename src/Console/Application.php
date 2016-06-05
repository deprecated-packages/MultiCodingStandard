<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\Console;

use Symfony\Component\Console\Application as SymfonyApplication;

final class Application extends SymfonyApplication
{
    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct('Symplify Coding Standard', null);
    }
}
