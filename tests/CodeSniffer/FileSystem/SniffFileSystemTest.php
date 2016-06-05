<?php

namespace Symplify\MultiCodingStandard\Tests\CodeSniffer\FileSystem;

use phpunit\framework\TestCase;
use Symplify\MultiCodingStandard\CodeSniffer\FileSystem\SniffFileSystem;
use Symplify\MultiCodingStandard\Contract\CodeSniffer\FileSystem\SniffFileSystemInterface;

final class SniffFileSystemTest extends TestCase
{
    /**
     * @var SniffFileSystemInterface
     */
    private $sniffFileSystem;

    protected function setUp()
    {
        $this->sniffFileSystem = new SniffFileSystem(__DIR__.'/SniffFileSystemSource');
    }

    public function testDetectUnderscoreLowercaseFromSniffClasses()
    {
        $foundSniffFiles = $this->sniffFileSystem->findAllSniffs();
        $this->assertCount(2, $foundSniffFiles);

        $this->assertContains('tests/CodeSniffer/FileSystem/SniffFileSystemSource/OneSniff.php', $foundSniffFiles[0]);
        $this->assertContains('tests/CodeSniffer/FileSystem/SniffFileSystemSource/TwoSniff.php', $foundSniffFiles[1]);
    }
}
