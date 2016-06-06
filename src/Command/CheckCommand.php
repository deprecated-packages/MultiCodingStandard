<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\Command;

use Exception;
use PHP_CodeSniffer;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\StyleInterface;
use Symfony\Component\Finder\Finder;

final class CheckCommand extends AbstractCommand
{
    /**
     * @var PHP_CodeSniffer
     */
    private $codeSniffer;

    /**
     * @var StyleInterface
     */
    private $style;

    public function __construct(PHP_CodeSniffer $codeSniffer, StyleInterface $style)
    {
        parent::__construct();

        $this->codeSniffer = $codeSniffer;
        $this->style = $style;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('check');
        $this->setDescription('Check coding standard in particular directory');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            foreach ($input->getArgument('path') as $path) {
                $this->checkDirectory($path);
            }

            return 0;
        } catch (Exception $exception) {
            $this->style->error($exception->getMessage());

            return 1;
        }
    }

    /**
     * @param string $path
     */
    private function checkDirectory($path)
    {
        foreach ((new Finder())->in($path)->files() as $filePath => $fileInfo) {
            $file = $this->codeSniffer->processFile($filePath);
        }
    }
}
