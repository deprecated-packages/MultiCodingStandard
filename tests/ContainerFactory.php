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
        $configurator = new Configurator();
        $configurator->setTempDirectory(TEMP_DIR);
        $configurator->addConfig(__DIR__.'/../src/config/config.neon');
        $configurator->addParameters(['eee' => 'eee']);

        return $configurator->createContainer();
    }
}
