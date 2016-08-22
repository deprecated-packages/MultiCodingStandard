<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\PhpCsFixer\Configuration;

use Symplify\MultiCodingStandard\Contract\PhpCsFixer\Configuration\OptionResolver\OptionResolverInterface;
use Symplify\PHP7_CodeSniffer\Exception\Configuration\MissingOptionResolverException;

final class ConfigurationResolver
{
    /**
     * @var OptionResolverInterface[]
     */
    private $optionResolvers;

    public function addOptionResolver(OptionResolverInterface $optionResolver)
    {
        $this->optionResolvers[$optionResolver->getName()] = $optionResolver;
    }

    public function resolve(string $name, array $source) : array
    {
        $this->ensureResolverExists($name);
        return $this->optionResolvers[$name]->resolve($source);
    }

    private function ensureResolverExists(string $name)
    {
        if (!isset($this->optionResolvers[$name])) {
            throw new MissingOptionResolverException(sprintf(
                'Resolver for "%s" value is not registered. '.
                'Add it via $configurationResolver->addOptionResolver(...).',
                $name
            ));
        }
    }

//    /**
//     * @var FixerFileSystem
//     */
//    private $fixerFileSystem;

//    /**
//     * @var FixerFactory
//     */
//    private $fixerFactory;
//
//    public function __construct(FixerFileSystem $fixerFileSystem, FixerFactory $fixerFactory)
//    {
//        $this->fixerFileSystem = $fixerFileSystem;
//        $this->fixerFactory = $fixerFactory;
//    }
//
//    public function create() : ConfigurationResolver
//    {
//        $allFixerFiles = $this->fixerFileSystem->findAllFixers();
//        $allFixerObjects = $this->fixerFactory->createFixersFromFiles($allFixerFiles);
//
//        $configurationResolver = new ConfigurationResolver();
//        $configurationResolver->setAllFixers($allFixerObjects);
//
//        return $configurationResolver;
//    }
}
