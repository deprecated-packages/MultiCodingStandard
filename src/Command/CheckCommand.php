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
use Symfony\Component\Console\Style\StyleInterface;
use Symfony\Component\Finder\Finder;
use Symplify\MultiCodingStandard\Console\ExitCode;
use Symplify\MultiCodingStandard\Contract\CodeSniffer\CodeSnifferFactoryInterface;

final class CheckCommand extends Command
{
    /**
     * @var PHP_CodeSniffer
     */
    private $codeSniffer;

    /**
     * @var StyleInterface
     */
    private $style;

    /**
     * @var CodeSnifferFactoryInterface
     */
    private $codeSnifferFactory;

    public function __construct(
        CodeSnifferFactoryInterface $codeSnifferFactory,
        StyleInterface $style
    ) {
        parent::__construct();

        $this->codeSnifferFactory = $codeSnifferFactory;
        $this->style = $style;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('check');
        $this->addArgument('path', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'The path(s)', null);
        $this->setDescription('Check coding standard in one or more directories.');
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

            return ExitCode::SUCCESS;
        } catch (Exception $exception) {
            $this->style->error($exception->getMessage());

            return ExitCode::ERROR;
        }
    }

    /**
     * @param string $path
     */
    private function checkDirectory($path)
    {
        // code sniffer
        foreach ((new Finder())->in($path)->files() as $filePath => $fileInfo) {
            $file = $this->getCodeSniffer()->processFile($filePath);

        }

        // php-cs-fixer
        

        $this->style->success(
            sprintf('Directory "%s" was checked!', $path)
        );
    }

    /**
     * Lazy loaded due to duplicated constants in setup
     * in CodeSniffer for both Sniffer and Fixer.
     *
     * @return PHP_CodeSniffer
     */
    private function getCodeSniffer()
    {
        if ($this->codeSniffer) {
            return $this->codeSniffer;
        }

        $this->codeSniffer = $this->codeSnifferFactory->create();

        return $this->codeSniffer;
    }
}
