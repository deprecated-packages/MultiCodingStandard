<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\MultiCodingStandard\Tests\PhpCsFixer\PhpCsFixerFactory\FixerLevel;

use phpunit\framework\TestCase;
use Symfony\CS\Fixer;
use Symplify\MultiCodingStandard\Tests\ContainerFactory;

final class FixerLevelTest extends TestCase
{
    /**
     * @var Fixer
     */
    private $phpCsFixer;

    protected function setUp()
    {
        $container = (new ContainerFactory())->createWithConfig(__DIR__.'/config/config.neon');
        $this->phpCsFixer = $container->getByType(Fixer::class);
    }

    public function testInstance()
    {
        $this->assertInstanceOf(Fixer::class, $this->phpCsFixer);
    }
}
