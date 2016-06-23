<?php

namespace Symplify\MultiCodingStandard\Tests\CodeSniffer\CodeSnifferFactory\Sniff;

use PHP_CodeSniffer;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_Assert;
use Symplify\MultiCodingStandard\Contract\CodeSniffer\CodeSnifferFactoryInterface;
use Symplify\MultiCodingStandard\Tests\ContainerFactory;
use SymplifyCodingStandard\Sniffs\Naming\AbstractClassNameSniff;

final class SniffTest extends TestCase
{
    /**
     * @var CodeSnifferFactoryInterface
     */
    private $codeSnifferFactory;

    protected function setUp()
    {
        $container = (new ContainerFactory())->createWithConfig(__DIR__ . '/config/config.neon');
        $this->codeSnifferFactory = $container->getByType(CodeSnifferFactoryInterface::class);
    }

    public function testInstance()
    {
        $this->assertInstanceOf(PHP_CodeSniffer::class, $this->codeSnifferFactory->create());
    }

    public function testProcessFile()
    {
        $file = $this->getCodeSniffer()->processFile(__DIR__ . '/SniffSource/SomeAbstractClass.php');
        $this->assertSame(1, $file->getErrorCount());

        $error = $file->getErrors()[5][10][0];
        $this->assertSame('SymplifyCodingStandard.Naming.AbstractClassName', $error['source']);
    }

    public function testRegisteredSniffs()
    {
        $registeredSniffs = PHPUnit_Framework_Assert::getObjectAttribute($this->getCodeSniffer(), 'sniffs');
        $this->assertCount(1, $registeredSniffs);
        $this->assertSame([AbstractClassNameSniff::class => AbstractClassNameSniff::class], $registeredSniffs);
    }

    /**
     * @return PHP_CodeSniffer
     */
    private function getCodeSniffer()
    {
        return $this->codeSnifferFactory->create();
    }
}
