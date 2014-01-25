<?php

namespace Wokis\Geonames;

/**
 * Thrown when the converter function is called without setting a source first.
 *
 * @author Kacper <kacper@kacper.se>
 */
class NoSourceException extends \BadMethodCallException
{
    /**
     * Constructor.
     *
     * @param string $caller The method that was called before a source was set
     */
    public function __construct($caller)
    {
        parent::__construct(sprintf('%s() must have a source, none given before calling.', $caller));
    }
}
