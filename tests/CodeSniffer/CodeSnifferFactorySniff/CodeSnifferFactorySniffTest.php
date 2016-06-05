<?php

namespace Symplify\MultiCodingStandard\Tests\CodeSniffer\CodeSnifferFactorySniff;

use PHP_CodeSniffer;
use phpunit\framework\TestCase;
use PHPUnit_Framework_Assert;
use Symplify\MultiCodingStandard\Tests\ContainerFactory;
use SymplifyCodingStandard\Sniffs\Naming\AbstractClassNameSniff;

final class CodeSnifferFactorySniffTest extends TestCase
{
    /**
     * @var PHP_CodeSniffer
     */
    private $codeSniffer;

    protected function setUp()
    {
        $container = (new ContainerFactory())->createWithConfig(__DIR__.'/config/config.neon');
        $this->codeSniffer = $container->getByType(PHP_CodeSniffer::class);
    }

    public function testInstance()
    {
        $this->assertInstanceOf(PHP_CodeSniffer::class, $this->codeSniffer);
    }

    public function testProcessFile()
    {
        $file = $this->codeSniffer->processFile(__DIR__ . '/CodeSnifferFactorySource/SomeAbstractClass.php');
        $this->assertSame(1, $file->getErrorCount());

        $error = $file->getErrors()[5][10][0];
        $this->assertSame('SymplifyCodingStandard.Naming.AbstractClassName', $error['source']);
    }

    public function testRegisteredSniffs()
    {
        $registeredSniffs = PHPUnit_Framework_Assert::getObjectAttribute($this->codeSniffer, 'sniffs');
        $this->assertCount(1, $registeredSniffs);
        $this->assertSame([AbstractClassNameSniff::class => AbstractClassNameSniff::class], $registeredSniffs);
    }
}
