<?php

namespace Live\Collection;

/**
 * Modern File
 * Reads a file in the roots way
 *
 * @package Live\Collection
 */
class RootsFile implements \Iterator
{
    /**
     * File pointer
     *
     * @var resource
     */
    protected $fp;

    /**
     * Key control
     *
     * @var int
     */
    protected $key;

    /**
     * Current line
     *
     * @var string
     */
    protected $current;

    /**
     * Filename
     *
     * @var string
     */
    protected $fileName;

    public function __construct($fileName)
    {
        $this->fp = fopen($fileName, 'r');
        $this->fileName = $fileName;
        $this->key = 0;
    }

    public function __destruct()
    {
        fclose($this->fp);
    }

    public function current()
    {
        return $this->current;
    }

    public function key(): int
    {
        return $this->key;
    }

    public function next()
    {
        if ($this->valid()) {
            $this->current = fgets($this->fp);
            $this->key++;
        }
    }

    public function rewind()
    {
        $this->__destruct();
        $this->__construct($this->fileName);
    }

    public function valid(): bool
    {
        return !feof($this->fp);
    }
}
