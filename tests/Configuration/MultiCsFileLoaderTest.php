<?php

namespace Symplify\MultiCodingStandard\Tests\Configuration;

use phpunit\framework\TestCase;
use Symplify\MultiCodingStandard\Configuration\MultiCsFileLoader;
use Symplify\MultiCodingStandard\Contract\Configuration\MultiCsFileLoaderInterface;

final class MultiCsFileLoaderTest extends TestCase
{
    /**
     * @var MultiCsFileLoaderInterface
     */
    private $multiCsFileLoader;

    protected function setUp()
    {
        $this->multiCsFileLoader = new MultiCsFileLoader(__DIR__.'/multi-cs.json');
    }

    public function testLoad()
    {
        $loadedFile = $this->multiCsFileLoader->load();
        $this->assertSame([
           'key' => 'value'
        ], $loadedFile);
    }
}