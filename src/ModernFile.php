<?php

namespace Live\Collection;

/**
 * Modern File
 * Reads a file with the power of SplFileInfo
 *
 * @package Live\Collection
 */
class ModernFile extends \SplFileObject implements \Iterator
{
    public function __construct(string $path)
    {
        parent::__construct($path);
    }
}
