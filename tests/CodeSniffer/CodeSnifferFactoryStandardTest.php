<?php

namespace Symplify\MultiCodingStandard\Tests\CodeSniffer;

use PHP_CodeSniffer;
use PHPUnit_Framework_Assert;
use PHPUnit_Framework_TestCase;
use Symplify\MultiCodingStandard\Tests\ContainerFactory;
use SymplifyCodingStandard\Sniffs\Naming\AbstractClassNameSniff;

final class CodeSnifferFactoryStandardTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PHP_CodeSniffer
     */
    private $codeSniffer;

    protected function setUp()
    {
        $container = (new ContainerFactory())->create();
        $this->codeSniffer = $container->getByType(PHP_CodeSniffer::class);
    }

    public function testRegisteredSniffs()
    {
        // 2DO: configuration -> load whole PSR-2 standard

        $registeredSniffs = PHPUnit_Framework_Assert::getObjectAttribute($this->codeSniffer, 'sniffs');
        $this->assertCount(1, $registeredSniffs);
        $this->assertSame([AbstractClassNameSniff::class => AbstractClassNameSniff::class], $registeredSniffs);
    }
}
