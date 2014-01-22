<?php

namespace Wokis\Geonames;

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
