<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\Command;

use Exception;
use PHP_CodeSniffer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

final class CheckCommand extends Command
{
    /**
     * @var PHP_CodeSniffer
     */
    private $codeSniffer;

    public function __construct(PHP_CodeSniffer $codeSniffer)
    {
        parent::__construct();

        $this->codeSniffer = $codeSniffer;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('check');
        $this->addArgument('path', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'The path(s)', null);
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
            $output->write(
                sprintf('<error>%s</error>', $exception->getMessage())
            );

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
            var_dump($file->getErrorCount());
        }
    }
}
