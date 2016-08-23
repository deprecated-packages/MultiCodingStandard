<?php

namespace Symplify\MultiCodingStandard\Tests\PhpCsFixer\Factory;

use PHPUnit\Framework\TestCase;
use Symfony\CS\ConfigurationResolver;
use Symfony\CS\Fixer;
use Symfony\CS\FixerInterface;
use Symplify\MultiCodingStandard\PhpCsFixer\Factory\FixerResolver;

final class FixerResolverTest extends TestCase
{
    /**
     * @var FixerResolver
     */
    private $fixerResolver;

    protected function setUp()
    {
        $this->fixerResolver = new FixerResolver($this->createConfigurationResolver());
    }

    public function testResolveFixers()
    {
        $fixers = $this->fixerResolver->resolveFixers([]);
        $this->assertCount(0, $fixers);

        $fixers = $this->fixerResolver->resolveFixers(['array_element_no_space_before_comma']);
        $this->assertCount(1, $fixers);
    }

    /**
     * @dataProvider provideResolveFixersByLevelAndExcludedFixers
     */
    public function testResolveFixerLevels(array $fixerLevels, array $excludedFixers, int $expectedFixerCount)
    {
        $fixers = $this->fixerResolver->resolveFixersByLevelAndExcludedFixers($fixerLevels, $excludedFixers);
        $this->assertCount($expectedFixerCount, $fixers);
    }

    public function provideResolveFixersByLevelAndExcludedFixers() : array
    {
        return [
            [[], [], 0],
            [['psr1'], [], 3],
            [['psr2'], [], 24],
            [['psr2'], ['visibility'], 23],
            [['psr1', 'psr2'], [], 27],
            [['psr1', 'psr2'], ['visibility'], 26]
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