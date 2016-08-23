<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\Report;

use Symplify\PHP7_CodeSniffer\Report\ErrorDataCollector as CodeSnifferErrorDataCollector;

final class ErrorDataCollector
{
    /**
     * @var CodeSnifferErrorDataCollector
     */
    private $codeSnifferErrorDataCollector;

    public function __construct(CodeSnifferErrorDataCollector $codeSnifferErrorDataCollector)
    {
        $this->codeSnifferErrorDataCollector = $codeSnifferErrorDataCollector;
    }

    public function getErrorCount() : int
    {
        return $this->codeSnifferErrorDataCollector->getErrorCount();
    }
}
