<?php

namespace Symplify\MultiCodingStandard\Tests\CodeSniffer\CodeSnifferFactory\Standard;

use PHP_CodeSniffer;
use phpunit\framework\TestCase;
use PHPUnit_Framework_Assert;
use Symplify\MultiCodingStandard\Tests\ContainerFactory;

final class StandardTest extends TestCase
{
    /**
     * @var PHP_CodeSniffer
     */
    private $codeSniffer;

    protected function setUp()
    {
        $container = (new ContainerFactory())->createWithConfig(__DIR__ . '/config/config.neon');
        $this->codeSniffer = $container->getByType(PHP_CodeSniffer::class);
    }

    public function testRegisteredSniffsFromPsr2()
    {
        $registeredSniffs = PHPUnit_Framework_Assert::getObjectAttribute($this->codeSniffer, 'sniffs');
        $this->assertCount(41, $registeredSniffs);
    }
}
