<?php

namespace Wokis\Geonames;

use Wokis\StdExceptions\FileSaveException;

/**
 * Options for json_encode.
 *
 * JSON_UNESCAPED_UNICODE, JSON_PRETTY_PRINT 
 *  and JSON_UNESCAPED_SLASHES are not available 
 *  in PHP < 5.4
 */
define('JSON_OPTIONS', JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

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
    private function isFlagSet($bitmask, $flag)
    {
        if (($bitmask & $flag) == $flag) {
            return true;
        }

        return false;
    }

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

            $json = json_encode($dataset, JSON_OPTIONS);

            /**
             * Since we are writing JSON line by line we need to do some black magic
             *  if we want JSON_PRETTY_PRINT.
             *
             * When JSON_PRETTY_PRINT is set we add the necessary new line characters
             *  and intend as necessary.
             */
            if ($this->isFlagSet(JSON_OPTIONS, JSON_PRETTY_PRINT)) {
                $prettyJson = "\n";
               
                $jsonLines = explode("\n", $json);

                foreach ($jsonLines as $line) {
                    $prettyJson .= '    ' . $line;
                    if ($jsonLines[count($jsonLines) - 1] != $line) {
                        $prettyJson .= "\n";
                    }
                }
                $json = $prettyJson;
            }

            fwrite($handle, $json);
            fwrite($handle, ',');
        }

        // revert the file pointer one byte to remove the last comma punctuation mark
        fseek($handle, -1, SEEK_CUR);

        if ($this->isFlagSet(JSON_OPTIONS, JSON_PRETTY_PRINT)) {
            fwrite($handle, "\n");
        }

        fwrite($handle, ']');

        fclose($handle);
        fclose($this->source->fileHandle);

        return true;
    }
}
