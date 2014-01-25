<?php

namespace Wokis\Geonames;

class ColumnCountNotEqual extends \RuntimeException
{
    /**
     * Constructor.
     *
     * @param string $sourceColumnCount
     * @param string $lineColumnCount
     */
    public function __construct($sourceColumnCount, $lineColumnCount)
    {
        parent::__construct(
            sprintf(
                'The number of columns in the source format and in the source file is not equal.
                Source format defines %s column(s) while source file returned %s column(s).',
                $sourceColumnCount,
                $lineColumnCount
            )
        );
    }
}
