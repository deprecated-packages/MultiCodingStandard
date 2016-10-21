<?php

declare(strict_types=1);

namespace Symplify\MultiCodingStandard\Tests\PhpCsFixer\Factory;

use PHPUnit\Framework\TestCase;
use Symfony\CS\ConfigurationResolver;
use Symfony\CS\Fixer;
use Symfony\CS\FixerInterface;
use Symplify\MultiCodingStandard\PhpCsFixer\Factory\FixerFactory;

final class FixerFactoryTest extends TestCase
{
    /**
     * @var FixerFactory
     */
    private $fixerFactory;

    protected function setUp()
    {
        $this->fixerFactory = new FixerFactory($this->createConfigurationResolver());
    }

    /**
     * @dataProvider provideCreateData
     */
    public function testResolveFixerLevels(array $fixerLevels, array $fixers, array $excludedFixers, int $expectedFixerCount)
    {
        $fixers = $this->fixerFactory->createFromLevelsFixersAndExcludedFixers($fixerLevels, $fixers, $excludedFixers);
        $this->assertCount($expectedFixerCount, $fixers);

        if (count($fixers)) {
            $fixer = $fixers[0];
            $this->assertInstanceOf(FixerInterface::class, $fixer);
        }
    }

    public function provideCreateData() : array
    {
        return [
            [[], [], [], 0],
            [[], ['array_element_no_space_before_comma'], [], 1],
            [['psr1'], [], [], 3],
            [['psr2'], [], [], 24],
            [['psr2'], [], ['visibility'],  23],
            [['psr1', 'psr2'], [], [], 27],
            [['psr1', 'psr2'], [], ['visibility'], 26]
        ];
    }

    private function createConfigurationResolver() : ConfigurationResolver
    {
        $configurationResolver = new ConfigurationResolver();
        $configurationResolver->setAllFixers($this->getAllFixers());
        return $configurationResolver;
    }

    /**
     * @return FixerInterface[]
     */
    private function getAllFixers() : array
    {
        $fixer = new Fixer();
        $fixer->registerBuiltInFixers();
        return $fixer->getFixers();
    }
}
