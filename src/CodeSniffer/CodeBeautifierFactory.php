<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\CodeSniffer;

use Symplify\MultiCodingStandard\Contract\CodeSniffer\CodeBeautifierFactoryInterface;
use Symplify\MultiCodingStandard\Contract\CodeSniffer\CodeSnifferFactoryInterface;

final class CodeBeautifierFactory implements CodeBeautifierFactoryInterface
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
        // high verbosity
        if (!defined('PHP_CODESNIFFER_VERBOSITY')) {
            define('PHP_CODESNIFFER_VERBOSITY', 2);
        }

        // enables fixer
        if (!defined('PHP_CODESNIFFER_CBF')) {
            define('PHP_CODESNIFFER_CBF', true);
        }

        $codeSnifferCli = new \PHP_CodeSniffer_CLI();
//        $codeSnifferCli->runphpcbf();

        $cliValues = $codeSnifferCli->getDefaults();
        $cliValues['verbosity']    = 0;
        $cliValues['showProgress'] = false;
        $cliValues['generator']    = '';
        $cliValues['explain']      = false;
        $cliValues['interactive']  = false;
        $cliValues['showSources']  = false;
        $cliValues['reportFile']   = null;
        $cliValues['reports']      = array();

        $diffFile = getcwd().'/phpcbf-fixed.diff';
        $cliValues['reports'] = array('diff' => $diffFile);
        $codeSnifferCli->setCommandLineValues($cliValues);


        $codeSniffer = $this->codeSnifferFactory->create(true);
        $codeSniffer->setCli($codeSnifferCli);

        return $codeSniffer;
    }
}
