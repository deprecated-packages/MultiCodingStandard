<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\CodeSniffer\FileSystem;

use Symfony\Component\Finder\Finder;
use Symplify\MultiCodingStandard\Contract\CodeSniffer\FileSystem\SniffFileSystemInterface;

final class SniffFileSystem implements SniffFileSystemInterface
{
    /**
     * @var string
     */
    private $vendorDir;

    /**
     * @param string $vendorDir
     */
    public function __construct($vendorDir)
    {
        $this->vendorDir = $vendorDir;
    }

    /**
     * {@inheritdoc}
     */
    public function findAllSniffs()
    {
        $sniffFilesInfo = (new Finder())->files()
            ->in($this->vendorDir)
            ->name('*Sniff.php');

        return array_keys(iterator_to_array($sniffFilesInfo));
    }
}
