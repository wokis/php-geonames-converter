<?php

namespace Wokis\StdExceptions;

class FileOpenException extends \RuntimeException
{
    /**
     * Constructor.
     *
     * @param string $filePath The path to the file that could not be opened
     */
    public function __construct($filePath)
    {
        parent::__construct(sprintf('The file "%s" could not be opened.', $filePath));
    }
}
