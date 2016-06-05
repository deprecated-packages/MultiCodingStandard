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
    const JSON_FILE_NAME = 'multi-cs.json';

    /**
     * @var string
     */
    private $baseDir;

    /**
     * @param string $baseDir
     */
    public function __construct($baseDir)
    {
        $this->baseDir = $baseDir;
    }

    /**
     * {@inheritdoc}
     */
    public function load()
    {
        $file = $this->getMcsFileLocation();
        $fileContent = file_get_contents($file);
        return Json::decode($fileContent, true);
    }

    /**
     * @return string
     */
    private function getMcsFileLocation()
    {
        return $this->baseDir.'/'.self::JSON_FILE_NAME;
    }
}
