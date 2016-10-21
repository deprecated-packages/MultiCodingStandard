<?php

declare(strict_types=1);

namespace Symplify\MultiCodingStandard\Tests\Configuration;

use PHPUnit\Framework\TestCase;
use Symplify\MultiCodingStandard\Configuration\MultiCsFileLoader;

final class MultiCsFileLoaderTest extends TestCase
{
    /**
     * @var MultiCsFileLoader
     */
    private $multiCsFileLoader;

    protected function setUp()
    {
        $this->multiCsFileLoader = new MultiCsFileLoader(__DIR__.'/multi-cs-key-value.json');
    }

    public function testLoad()
    {
        $loadedFile = $this->multiCsFileLoader->load();
        $this->assertSame([
           'key' => 'value'
        ], $loadedFile);
    }
}