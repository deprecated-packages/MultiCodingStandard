<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\CodeSniffer;

use Symplify\MultiCodingStandard\Contract\CodeSniffer\CodeSnifferFactoryInterface;

final class CodeBeautifierFactory
{
    /**
     * @var CodeSnifferFactoryInterface
     */
    private $codeSnifferFactory;

    public function __construct(CodeSnifferFactoryInterface $codeSnifferFactory)
    {
        $this->codeSnifferFactory = $codeSnifferFactory;
    }

    /**
     * @return CodeBeautifier
     */
    public function create()
    {
        if (!defined('PHP_CODESNIFFER_CBF')) {
            define('PHP_CODESNIFFER_CBF', true);
        }
        return $this->codeSnifferFactory->create();
    }
}
