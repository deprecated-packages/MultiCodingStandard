<?php

namespace Symplify\MultiCodingStandard\Tests;

use Nette\Configurator;
use Nette\DI\Container;

final class ContainerFactory
{
    /**
     * @return Container
     */
    public function create()
    {
        return $this->createWithConfig(__DIR__.'/../src/config/config.neon');
    }

    /**
     * @return Container
     */
    public function createWithConfig($config)
    {
        $configurator = new Configurator();
        $configurator->setTempDirectory(TEMP_DIR);
        $configurator->addConfig($config);

        return $configurator->createContainer();
    }
}
