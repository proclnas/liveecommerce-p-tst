<?php

namespace Live\Collection;

use PHPUnit\Framework\TestCase;
use \org\bovigo\vfs\vfsStream;

class RootsFileTest extends TestCase
{
    public function setUp(): void
    {
        vfsStream::setup('tmpDir', null, ['data' => 'foobar']);
        $this->tmpFile = 'vfs://tmpDir/data';
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function objectCanBeConstructed()
    {
        $rootsFile = new RootsFile($this->tmpFile);
        return $rootsFile;
    }

    /**
     * @test
     * @depends objectCanBeConstructed
     */
    public function initialStateShouldBeNull($rootsFile)
    {
        $this->assertNull($rootsFile->current());
    }

    /**
     * @test
     * @depends objectCanBeConstructed
     */
    public function nextCallShouldModifyObjectState()
    {
        vfsStream::setup('tmpDir', null, ['data' => 'line 1']);
        $file = 'vfs://tmpDir/data';
        $rootsFile = new RootsFile($file);
        $rootsFile->next();
        $this->assertEquals('line 1', $rootsFile->current());
    }

    /**
     * @test
     * @depends objectCanBeConstructed
     */
    public function keyShouldIncrementedOnNext()
    {
        vfsStream::setup('tmpDir', null, ['data' => 'any content']);
        $file = 'vfs://tmpDir/data';
        $rootsFile = new RootsFile($file);
        $this->assertEquals(0, $rootsFile->key());
        $rootsFile->next();
        $this->assertEquals(1, $rootsFile->key());
    }

    /**
     * @test
     * @depends objectCanBeConstructed
     */
    public function objectStateShouldZeroedAfterRewind()
    {
        vfsStream::setup('tmpDir', null, ['data' => 'any content']);
        $file = 'vfs://tmpDir/data';
        $rootsFile = new RootsFile($file);
        $rootsFile->next();
        $rootsFile->rewind();
        $this->assertEquals(0, $rootsFile->key());
    }
}
