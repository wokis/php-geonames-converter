<?php

namespace Wokis\StdExceptions;

/**
 * Thrown when a file can not be found
 *
 * @author Kacper <kacper@kacper.se>
 */
class FileNotFoundException extends \RuntimeException
{
    /**
     * Constructor.
     *
     * @param string $filePath The path to the file that was not found
     */
    public function __construct($filePath)
    {
        parent::__construct(sprintf('The file "%s" does not exist.', $filePath));
    }
}
