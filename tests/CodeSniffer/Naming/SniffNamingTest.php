<?php

namespace Symplify\MultiCodingStandard\Tests\CodeSniffer\Naming;

use phpunit\framework\TestCase;
use Symplify\MultiCodingStandard\CodeSniffer\Naming\SniffNaming;
use Symplify\MultiCodingStandard\Contract\CodeSniffer\Naming\SniffNamingInterface;

final class SniffNamingTest extends TestCase
{
    /**
     * @var SniffNamingInterface
     */
    private $sniffNaming;

    protected function setUp()
    {
        $this->sniffNaming = new SniffNaming();
    }

    public function testDetectUnderscoreLowercaseFromSniffNames()
    {
        $newNames = $this->sniffNaming->detectUnderscoreLowercaseFromSniffNames(['somestandard.group.specific']);
        $this->assertSame(['somestandard_sniffs_group_specificsniff'], $newNames);
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
