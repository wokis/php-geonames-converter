<?php

namespace Wokis\Geonames;

/**
 * Class resposible for setting up the source for conversion.
 * 
 * @author Kacper <kacper@kacper.se>
 */

class AllCountriesSource extends GeonamesDumpSource
{
    /**
     * CountryInfo columns.
     *
     * @return array An array of all the columns
     */
    public function columns()
    {
        return array(
            'geonames',
            'name',
            'asciiname',
            'alternatenames',
            'latitude',
            'longitude',
            'feature class',
            'feature code',
            'country code',
            'cc2',
            'admin1 code',
            'admin2 code',
            'admin3 code',
            'admin4 code',
            'population',
            'elevation',
            'dem',
            'timezone',
            'modification date',
        );
    }

    /**
     * Preprocessor method incase the source needs special treatment.
     *
     * For example the source might have a column header that needs to be
     *  removed or feed to self::columns().
     *
     * Most of the geonames dump files follow the same format, those who don't
     *  will need to be handled by this preprocessor method.
     *
     * $this->fileHandle is available for directly accessing the opened source file.
     */
    protected function preProcess()
    {
        // nothing to do here
    }
}
