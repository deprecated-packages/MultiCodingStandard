<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\Contract\Configuration;

interface MultiCsFileLoaderInterface
{
    /**
     * @return array
     */
    public function load();
}
