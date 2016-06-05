<?php

namespace Symplify\MultiCodingStandard\Tests\CodeSniffer\CodeSnifferFactoryStandard;

use PHP_CodeSniffer;
use phpunit\framework\TestCase;
use PHPUnit_Framework_Assert;
use Symplify\MultiCodingStandard\Tests\ContainerFactory;

final class ExcludeSniffs extends TestCase
{
    /**
     * @var PHP_CodeSniffer
     */
    private $codeSniffer;

    protected function setUp()
    {
        $container = (new ContainerFactory())->createWithConfig(__DIR__ . '/config/config-with-exclusion.neon');
        $this->codeSniffer = $container->getByType(PHP_CodeSniffer::class);
    }

    public function testRegisteredSniffsFromPsr2WithExclusion()
    {
        $registeredSniffs = PHPUnit_Framework_Assert::getObjectAttribute($this->codeSniffer, 'sniffs');
        $this->assertCount(40, $registeredSniffs);
    }
}
