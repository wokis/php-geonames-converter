<?php

namespace Wokis\Geonames;

use Wokis\StdExceptions\FileNotFoundException;
use Wokis\StdExceptions\FileOpenException;

/**
 * Base class responsible for opening and reading a geonames dump file.
 *
 * @link http://download.geonames.org/export/dump/readme.txt
 * @link http://download.geonames.org/export/dump/
 *
 * @author Kacper <kacper@kacper.se>
 */
abstract class GeonamesDumpSource
{
    abstract public function columns();
    abstract protected function preProcess();
    public $fileHandle;


    /**
     * Constructor.
     *
     * @param string $filePath The file to open
     * @throws \Wokis\StdExceptions\FileNotFoundException
     * @throws \Wokis\StdExceptions\FileOpenException
     */
    public function __construct($filePath)
    {
        if (! file_exists($filePath)) {
            throw new FileNotFoundException($filePath);
        }
        
        
        if (($handle = fopen($filePath, 'r')) === true) {
            throw new FileOpenException($filePath);
        }

        while (($line = fgetc($handle)) == '#') {
            // Advance the file pointer to a new line
            fgets($handle);
        }

        // Give back the stolen character from while above
        fseek($handle, -1, SEEK_CUR);

        $this->fileHandle = $handle;

        $this->preProcess();
    }
}
