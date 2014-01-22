<?php

namespace Wokis\Geonames;

use Wokis\StdExceptions\FileSaveException;

/**
 * Options for json_encode.
 *
 * JSON_UNESCAPED_UNICODE and JSON_UNESCAPED_SLASHES 
 *  are not available in PHP < 5.4
 *
 * JSON_PRETTY_PRINT shouldn't be used since we are
 *  writing json line by line
 */
define('JSON_OPTIONS', JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

/**
 * Class that handles the conversion from a geonames dump source into the JSON format.
 *
 * @param string $outputFilePath The path to a file to write to
 * @return bool Returns true if things go well
 *
 * @author Kacper <kacper@kacper.se>
 */
class JsonConverter extends AbstractConverter
{
    public function convert($outputFilePath)
    {
        if (! $this->source instanceof GeonamesDumpSource) {
            throw new NoSourceException(__METHOD__);
        }

        if (($handle = fopen($outputFilePath, 'wb')) === false) {
            throw new FileSaveException($outputFilePath);
        }

        fwrite($handle, '[');

        while (($line = fgetcsv($this->source->fileHandle, 0, "\t")) !== false) {
            $dataset = array_combine($this->source->columns(), $line);
            fwrite($handle, json_encode($dataset, JSON_OPTIONS));
            fwrite($handle, ',');
        }

        // revert the file pointer one byte to remove the last comma punctuation mark
        fseek($handle, -1, SEEK_CUR);

        fwrite($handle, ']');

        fclose($handle);
        fclose($this->source->fileHandle);

        return true;
    }
}
