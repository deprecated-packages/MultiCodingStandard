<?php

namespace Symplify\MultiCodingStandard\Tests\CodeSniffer\Naming;

use PHPUnit_Framework_TestCase;
use Symplify\MultiCodingStandard\CodeSniffer\Naming\SniffNaming;
use Symplify\MultiCodingStandard\Contract\CodeSniffer\Naming\SniffNamingInterface;

final class SniffNamingTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var SniffNamingInterface
     */
    private $sniffNaming;

    protected function setUp()
    {
        $this->sniffNaming = new SniffNaming();
    }

    public function testDetectUnderscoreLowercaseFromSniffClasses()
    {
        $sniffClasses = ['SomeStandard\\Sniff\\Group\\SpecificSniff'];
        $names = $this->sniffNaming->detectUnderscoreLowercaseFromSniffClasses($sniffClasses);

        $this->assertSame(['somestandard_sniff_group_specificsniff'], $names);
    }

    public function testDetectDottedFromFilePaths()
    {
        $filePaths = ['/vendor/SomeStandard/Sniffs/Group/SpecificSniff.php'];
        $names = $this->sniffNaming->detectDottedFromFilePaths($filePaths);

        $this->assertSame([
            'SomeStandard.Group.Specific' => $filePaths[0]
        ], $names);
    }
}
