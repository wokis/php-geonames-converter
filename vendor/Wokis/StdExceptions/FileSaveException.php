<?php

namespace Wokis\StdExceptions;

/**
 * Thrown when a file can not be saved
 *
 * @author Kacper <kacper@kacper.se>
 */
class FileSaveException extends \RuntimeException
{
    /**
     * Constructor.
     *
     * @param string $filePath The path to the file that could not be saved
     */
    public function __construct($filePath)
    {
        parent::__construct(sprintf('The file "%s" could not be saved.', $filePath));
    }
}
