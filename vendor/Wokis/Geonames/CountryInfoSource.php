<?php

namespace Wokis\Geonames;

/**
 * Class resposible for setting up the source for conversion.
 * 
 * @author Kacper <kacper@kacper.se>
 */

class CountryInfoSource extends GeonamesDumpSource
{
    /**
     * CountryInfo columns.
     *
     * @return array An array of all the columns
     */
    public function columns()
    {
        return array(
            'ISO',
            'ISO3',
            'ISO-NumericFips',
            'fips',
            'Country',
            'Capital',
            'Area',
            'Population',
            'Continent',
            'tld',
            'CurrencyCode',
            'CurrencyName',
            'Phone',
            'PostalCodeFormat',
            'PostalCodeRegex',
            'Languages',
            'geonameid',
            'neighbours',
            'EquivalentFipsCode',
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
