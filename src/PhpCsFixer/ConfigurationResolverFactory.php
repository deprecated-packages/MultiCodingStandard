<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\PhpCsFixer;

use Symfony\CS\ConfigurationResolver;
use Symplify\MultiCodingStandard\Contract\PhpCsFixer\FileSystem\FixerFileSystemInterface;
use Symplify\MultiCodingStandard\PhpCsFixer\Fixer\FixerFactory;

final class ConfigurationResolverFactory
{
    /**
     * @var FixerFileSystemInterface
     */
    private $fixerFileSystem;

    /**
     * @var FixerFactory
     */
    private $fixerFactory;

    public function __construct(
        FixerFileSystemInterface $fixerFileSystem,
        FixerFactory $fixerFactory
    ) {
        $this->fixerFileSystem = $fixerFileSystem;
        $this->fixerFactory = $fixerFactory;
    }

    /**
     * @return ConfigurationResolver
     */
    public function create()
    {
        $allFixerFiles = $this->fixerFileSystem->findAllFixers();
        $allFixerObjects = $this->fixerFactory->createFixersFromFiles($allFixerFiles);

        $configurationResolver = new ConfigurationResolver();
        $configurationResolver->setAllFixers($allFixerObjects);

        return $configurationResolver;
    }
}
