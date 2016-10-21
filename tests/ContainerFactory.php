<?php

declare(strict_types=1);

namespace Symplify\MultiCodingStandard\Tests;

use Nette\Configurator;
use Nette\DI\Container;

final class ContainerFactory
{
    public function create() : Container
    {
        return $this->createWithConfig(__DIR__.'/../src/config/config.neon');
    }

    public function createWithConfig($config) : Container
    {
        $configurator = new Configurator();
        $configurator->setTempDirectory(TEMP_DIR);
        $configurator->addConfig($config);

        return $configurator->createContainer();
    }
}
