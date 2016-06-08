<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\Command;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\StyleInterface;
use Symfony\Component\Finder\Finder;
use Symfony\CS\Fixer;
use Symplify\MultiCodingStandard\CodeSniffer\CodeBeautifier;
use Symplify\MultiCodingStandard\CodeSniffer\CodeBeautifierFactory;
use Symplify\MultiCodingStandard\Console\ExitCode;

final class FixCommand extends Command
{
    /**
     * @var CodeBeautifierFactory
     */
    private $codeBeautifierFactory;

    /**
     * @var StyleInterface
     */
    private $style;

    /**
     * @var Fixer
     */
    private $fixer;

    /**
     * @var CodeBeautifier
     */
    private $codeBeautifier;

    public function __construct(
        CodeBeautifierFactory $codeBeautifierFactory,
        Fixer $fixer,
        StyleInterface $style
    ) {
        parent::__construct();

        $this->codeBeautifierFactory = $codeBeautifierFactory;
        $this->fixer = $fixer;
        $this->style = $style;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('fix');
        $this->addArgument('path', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'The path(s)', null);
        $this->setDescription('Fix coding standard in one or more directories.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // note: needs to be lazy created, due to constant-options in PHP_CodeSniffer
        $this->codeBeautifier = $this->codeBeautifierFactory->create();
        var_dump($this->codeBeautifier);
        die;

        try {
            foreach ($input->getArgument('path') as $path) {
                $this->fixDirectory($path);
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
    private function fixDirectory($path)
    {
        // code sniffer
        foreach (Finder::create()->in($path)->files() as $filePath => $fileInfo) {
            $file = $this->codeSniffer->processFile($filePath);
            var_dump($file->getErrorCount());
        }

        // php-cs-fixer
        

        $this->style->success(
            sprintf('Directory "%s" was checked!', $path)
        );
    }
}
