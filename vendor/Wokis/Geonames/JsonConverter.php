<?php

namespace Wokis\Geonames;

use Wokis\StdExceptions\FileSaveException;
use Wokis\Geonames\ColumnCountNotEqual;

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
 * @author Kacper <kacper@kacper.se>
 */
class JsonConverter extends AbstractConverter
{
    /**
     * Convert a GeonamesDumpSource into JSON line by line
     *
     * @param string $outputFilePath The path to a file to write to
     * @throws ColumnCountNotEqual
     * @throws \Wokis\StdExceptions\FileSaveException
     * @throws NoSourceException
     * @return bool Returns true if things go well
     */
    public function convert($outputFilePath)
    {
        if (! $this->source instanceof GeonamesDumpSource) {
            throw new NoSourceException(__METHOD__);
        }

        if (($handle = fopen($outputFilePath, 'wb')) === false) {
            throw new FileSaveException($outputFilePath);
        }

        $columns = $this->source->columns();

        fwrite($handle, '[');

        while (($line = fgets($this->source->fileHandle)) !== false) {
            
            $line = str_replace("\n", '', $line);
            $line = explode("\t", $line);
            
            $dataset = array_combine($columns, $line);
            
            if ($dataset === false) {
                throw new ColumnCountNotEqual(count($columns), count($line));
            }

            $json = json_encode($dataset, JSON_OPTIONS);

            /**
             * Since we are writing JSON line by line we need to do some black magic
             *  if we want JSON_PRETTY_PRINT.
             *
             * When JSON_PRETTY_PRINT is set we add the necessary new line characters
             *  and intend as necessary.
             */
            if ((JSON_PRETTY_PRINT & JSON_OPTIONS) == JSON_PRETTY_PRINT) {
                $prettyJson = "\n";
               
                $jsonLines = explode("\n", $json);

                foreach ($jsonLines as $line) {
                    $prettyJson .= '    ' . $line;
                    $prettyJson .= "\n";
                }

                // remove last new line character
                $prettyJson = substr($prettyJson, 0, -1);

                $json = $prettyJson;
            }

            fwrite($handle, $json);
            fwrite($handle, ',');

        }

        // revert the file pointer one byte to remove the last comma punctuation mark
        fseek($handle, -1, SEEK_CUR);

        if ((JSON_PRETTY_PRINT & JSON_OPTIONS) == JSON_PRETTY_PRINT) {
            fwrite($handle, "\n");
        }

        fwrite($handle, ']');

        fclose($handle);
        fclose($this->source->fileHandle);

        return true;
    }
}
