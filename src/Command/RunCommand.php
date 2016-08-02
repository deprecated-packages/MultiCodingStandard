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
use Symplify\MultiCodingStandard\Console\ExitCode;
use Symplify\PHP7_CodeSniffer\Configuration\ConfigurationResolver;
use Symplify\PHP7_CodeSniffer\Php7CodeSniffer;

final class RunCommand extends Command
{
    /**
     * @var Php7CodeSniffer
     */
    private $php7CodeSniffer;

    /**
     * @var StyleInterface
     */
    private $style;

    /**
     * @var ConfigurationResolver
     */
    private $configurationResolver;

    public function __construct(
        Php7CodeSniffer $php7CodeSniffer,
        StyleInterface $style,
        ConfigurationResolver $configurationResolver
    ) {
        parent::__construct();

        $this->php7CodeSniffer = $php7CodeSniffer;
        $this->style = $style;
        $this->configurationResolver = $configurationResolver;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('run');
        $this->addArgument('source', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'The path(s) to be checked.');
        $this->addOption('fix', null, null, 'Fix found violations.');
        $this->setDescription('Check coding standard in one or more directories.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $source = $this->configurationResolver->resolveSource($input->getArgument('source'));
        $isFixer = $input->getOption('fix');

        try {
            $this->php7CodeSniffer->runForSource($source, $isFixer);

            // todo: php-cs-fixer

            $this->style->success(
                sprintf('Sources "%s" were checked!', implode(',', $source))
            );

            return ExitCode::SUCCESS;
        } catch (Exception $exception) {
            $this->style->error($exception->getMessage());

            return ExitCode::ERROR;
        }
    }
}
