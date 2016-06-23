<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\Configuration;

use Nette\Utils\Json;
use Symplify\MultiCodingStandard\Contract\Configuration\MultiCsFileLoaderInterface;
use Symplify\MultiCodingStandard\Exception\Configuration\MultiCsFileNotFoundException;

final class MultiCsFileLoader implements MultiCsFileLoaderInterface
{
    /**
     * @var string
     */
    private $multiCsJsonFile;

    /**
     * @param string $multiCsJsonFile
     */
    public function __construct($multiCsJsonFile)
    {
        $this->multiCsJsonFile = $multiCsJsonFile;
    }

    /**
     * {@inheritdoc}
     */
    public function load()
    {
        $this->ensureFileExists($this->multiCsJsonFile);
        
        $fileContent = file_get_contents($this->multiCsJsonFile);
        return Json::decode($fileContent, true);
    }

    /**
     * @param string $multiCsJsonFile
     */
    private function ensureFileExists($multiCsJsonFile)
    {
        if (!file_exists($multiCsJsonFile)) {
            throw new MultiCsFileNotFoundException(
                sprintf(
                    'File "multi-cs.json" was not found in "%s". Did you forget to create it?',
                    realpath(dirname($multiCsJsonFile)).'/'.basename($multiCsJsonFile)
                )
            );
        }
    }
}
