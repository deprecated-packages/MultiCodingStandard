<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\CodeSniffer;

use PHP_CodeSniffer;
use Symplify\MultiCodingStandard\CodeSniffer\FileSystem\SniffFileSystem;
use Symplify\MultiCodingStandard\Contract\CodeSniffer\CodeSnifferFactoryInterface;
use Symplify\MultiCodingStandard\Contract\Configuration\ConfigurationInterface;

final class CodeSnifferFactory implements CodeSnifferFactoryInterface
{
    /**
     * @var ConfigurationInterface
     */
    private $configuration;

    /**
     * @var SniffFileSystem
     */
    private $sniffFileSystem;

    public function __construct(
        ConfigurationInterface $configuration,
        SniffFileSystem $sniffFileSystem
    ) {
        $this->configuration = $configuration;
        $this->sniffFileSystem = $sniffFileSystem;
    }

    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $codeSniffer = new PHP_CodeSniffer();
        $this->setupSniffs($codeSniffer);
        $this->setupErrorRecoding($codeSniffer);

        return $codeSniffer;
    }

    private function setupSniffs(PHP_CodeSniffer $codeSniffer)
    {
        $codeSniffer->registerSniffs(
            $this->sniffFileSystem->findAllSniffs(),
            $this->configuration->getActiveSniffs()
        );
        $codeSniffer->populateTokenListeners();
    }

    private function setupErrorRecoding(PHP_CodeSniffer $codeSniffer)
    {
        $codeSniffer->cli->setCommandLineValues([
            '-s', // showSources must be on, so that errors are recorded
        ]);
    }
}
