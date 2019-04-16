<?php

namespace Live\Collection;

use PHPUnit\Framework\TestCase;
use Live\Collection\ModernFile;
use Live\Collection\RootsFile;
use \org\bovigo\vfs\vfsStream;

class FileCollectionTest extends TestCase
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
        $collection = new FileCollection();
        return $collection;
    }

    /**
     * @test
     * @depends objectCanBeConstructed
     * @doesNotPerformAssertions
     */
    public function dataCanBeAdded()
    {
        $collection = new FileCollection();
        $collection->set('modern-file-1', new ModernFile($this->tmpFile));
        $collection->set('roots-file-1', new RootsFile($this->tmpFile));
    }

    /**
     * @test
     * @depends objectCanBeConstructed
     * @depends dataCanBeAdded
     */
    public function collectionShouldReceiveOnlyIteratorImplementation()
    {
        $collection = new FileCollection();
        $collection->set('modern-file-1', '/foo/bar');
        $this->assertEquals(0, $collection->count());

        $collection->set('modern-file-1', new ModernFile($this->tmpFile));
        $this->assertEquals(1, $collection->count());
    }

    /**
     * @test
     * @depends dataCanBeAdded
     */
    public function dataCanBeRetrieved()
    {
        $collection = new FileCollection();
        $collection->set('modern-file-1', new ModernFile($this->tmpFile));
        $collection->set('roots-file-1', new RootsFile($this->tmpFile));

        $this->assertInstanceOf(\Iterator::class, $collection->get('modern-file-1'));
        $this->assertInstanceOf(\Iterator::class, $collection->get('roots-file-1'));
    }

    /**
     * @test
     * @depends objectCanBeConstructed
     */
    public function newCollectionShouldNotContainItems()
    {
        $collection = new FileCollection();
        $this->assertEquals(0, $collection->count());
    }

    /**
     * @test
     * @depends dataCanBeAdded
     */
    public function collectionWithItemsShouldReturnValidCount()
    {
        $collection = new FileCollection();
        $collection->set('file1', new RootsFile($this->tmpFile));
        $collection->set('file2', new RootsFile($this->tmpFile));
        $collection->set('file3', new RootsFile($this->tmpFile));

        $this->assertEquals(3, $collection->count());
    }

    /**
     * @test
     * @depends dataCanBeAdded
     */
    public function addedItemShouldExistInCollection()
    {
        $collection = new FileCollection();
        $collection->set('file1', new RootsFile($this->tmpFile));

        $this->assertTrue($collection->has('file1'));
    }

    /**
     * @test
     * @depends collectionWithItemsShouldReturnValidCount
     */
    public function collectionCanBeCleaned()
    {
        $collection = new FileCollection();
        $collection->set('file1', new RootsFile($this->tmpFile));
        $this->assertEquals(1, $collection->count());

        $collection->clean();
        $this->assertEquals(0, $collection->count());
    }

    /**
     * @test
     * @depends objectCanBeConstructed
     */
    public function inexistentIndexShouldReturnDefaultValue()
    {
        $collection = new FileCollection();

        $this->assertNull($collection->get('index1'));
        $this->assertEquals('defaultValue', $collection->get('index1', 'defaultValue'));
    }
}
