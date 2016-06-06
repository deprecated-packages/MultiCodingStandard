<?php

namespace Symplify\MultiCodingStandard\Tests\CodeSniffer\CodeSnifferFactory\Sniff;

use PHP_CodeSniffer;
use phpunit\framework\TestCase;
use PHPUnit_Framework_Assert;
use Symplify\MultiCodingStandard\Tests\ContainerFactory;
use SymplifyCodingStandard\Sniffs\Naming\AbstractClassNameSniff;

final class NamedSniffTest extends TestCase
{
    /**
     * @var PHP_CodeSniffer
     */
    private $codeSniffer;

    protected function setUp()
    {
        $container = (new ContainerFactory())->createWithConfig(__DIR__ . '/config/config-named-sniffs.neon');
        $this->codeSniffer = $container->getByType(PHP_CodeSniffer::class);
    }

    public function testRegisteredSniffs()
    {
        $registeredSniffs = PHPUnit_Framework_Assert::getObjectAttribute($this->codeSniffer, 'sniffs');
        $this->assertCount(1, $registeredSniffs);
        // $this->assertSame([AbstractClassNameSniff::class => AbstractClassNameSniff::class], $registeredSniffs);
    }
}
