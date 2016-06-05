<?php

namespace Symplify\MultiCodingStandard\Tests\CodeSniffer\CodeSnifferFactoryStandard;

use PHP_CodeSniffer;
use PHPUnit_Framework_Assert;
use PHPUnit_Framework_TestCase;
use Symplify\MultiCodingStandard\Tests\ContainerFactory;

final class CodeSnifferFactoryStandardWithExclusionTest extends PHPUnit_Framework_TestCase
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
        // todo: exclude 1 and make it 40
        $this->assertCount(41, $registeredSniffs);
    }
}
