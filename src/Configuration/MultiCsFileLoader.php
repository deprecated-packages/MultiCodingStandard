<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\Configuration;

use Nette\Utils\Json;
use Symplify\MultiCodingStandard\Contract\Configuration\MultiCsFileLoaderInterface;

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
        $fileContent = file_get_contents($this->multiCsJsonFile);
        return Json::decode($fileContent, true);
    }
}
