<?php

namespace Symplify\MultiCodingStandard\Tests\CodeSniffer\FileSystem;

use PHPUnit_Framework_TestCase;
use Symplify\MultiCodingStandard\CodeSniffer\FileSystem\RulesetFileSystem;
use Symplify\MultiCodingStandard\Contract\CodeSniffer\FileSystem\RulesetFileSystemInterface;

final class RulesetFileSystemTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var RulesetFileSystemInterface
     */
    private $rulesetFileSystem;

    protected function setUp()
    {
        $this->rulesetFileSystem = new RulesetFileSystem(__DIR__.'/RulesetFileSystemSource');
    }

    public function testDetectUnderscoreLowercaseFromSniffClasses()
    {
        $foundRuleset = $this->rulesetFileSystem->getRulesetPathForStandardName('MyOwnStandard');
        $this->assertSame(__DIR__.'/RulesetFileSystemSource/MyOwnStandard/ruleset.xml', $foundRuleset);
    }

    /**
     * @expectedException \Exception
     */
    public function testFailOnMissingStandard()
    {
        $this->rulesetFileSystem->getRulesetPathForStandardName('MissingStandard');
    }
}
