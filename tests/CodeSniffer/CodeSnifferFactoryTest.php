<?php

namespace Symplify\MultiCodingStandard\Tests\CodeSniffer;

use PHP_CodeSniffer;
use PHPUnit_Framework_TestCase;
use Symplify\MultiCodingStandard\Tests\ContainerFactory;

final class CodeSnifferFactoryTest extends PHPUnit_Framework_TestCase
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

    public function testInstance()
    {
        $this->assertInstanceOf(PHP_CodeSniffer::class, $this->codeSniffer);
    }
}
