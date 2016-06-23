<?php

namespace Symplify\MultiCodingStandard\Tests\CodeSniffer\CodeSnifferFactory\Standard;

use PHP_CodeSniffer;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_Assert;
use Symplify\MultiCodingStandard\Contract\CodeSniffer\CodeSnifferFactoryInterface;
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

        /** @var CodeSnifferFactoryInterface $codeSnifferFactory */
        $codeSnifferFactory = $container->getByType(CodeSnifferFactoryInterface::class);
        $this->codeSniffer = $codeSnifferFactory->create();
    }

    public function testRegisteredSniffsFromPsr2WithExclusion()
    {
        $registeredSniffs = PHPUnit_Framework_Assert::getObjectAttribute($this->codeSniffer, 'sniffs');
        $this->assertCount(40, $registeredSniffs);
    }
}
