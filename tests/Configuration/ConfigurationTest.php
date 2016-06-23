<?php

namespace Symplify\MultiCodingStandard\Tests\Configuration;

use PHPUnit\Framework\TestCase;
use Symplify\MultiCodingStandard\CodeSniffer\Naming\SniffNaming;
use Symplify\MultiCodingStandard\Configuration\Configuration;
use Symplify\MultiCodingStandard\Configuration\MultiCsFileLoader;
use Symplify\MultiCodingStandard\Contract\Configuration\ConfigurationInterface;

final class ConfigurationTest extends TestCase
{
    /**
     * @var ConfigurationInterface
     */
    private $configuration;

    protected function setUp()
    {
        $this->configuration = $this->createConfigurationWithConfig(__DIR__.'/multi-cs.json');
    }

    public function testGetActiveSniffs()
    {
        $this->assertSame(['somecodingstandard_sniffs_group_specificsniff'], $this->configuration->getActiveSniffs());
    }

    public function testGetActiveStandards()
    {
        $this->assertSame(['SomeStandard'], $this->configuration->getActiveStandards());
    }

    public function testGetExcludedSniffs()
    {
        $this->assertSame(['SomeCodingStandard.Group.Specific'], $this->configuration->getExcludedSniffs());
    }

    public function testEmpty()
    {
        $configuration = $this->createConfigurationWithConfig(__DIR__.'/multi-cs-empty.json');

        $this->assertSame([], $configuration->getActiveSniffs());
        $this->assertSame([], $configuration->getExcludedSniffs());
        $this->assertSame([], $configuration->getActiveStandards());
    }

    /**
     * @param string $config
     * @return Configuration
     */
    private function createConfigurationWithConfig($config)
    {
        return new Configuration(
            new MultiCsFileLoader($config),
            new SniffNaming()
        );
    }
}
