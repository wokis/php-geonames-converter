<?php

namespace Wokis\Geonames;

/**
 * Base class resposible for the conversion process.
 *
 * @author Kacper <kacper@kacper.se>
 */
abstract class AbstractConverter
{
    abstract public function convert($outputFilePath);
    protected $source;

    /**
     * Set geonames source object.
     *
     * @param GeonamesDumpSource $source The geonames source object
     */
    public function source(GeonamesDumpSource $source)
    {
        $this->source = $source;
    }
}
