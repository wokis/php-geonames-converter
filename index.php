<?php

// Countries from http://download.geonames.org/export/dump/countryInfo.txt

//ini_set('memory_limit', '150M');

use Wokis\Geonames\CountryInfoSource;
use Wokis\Geonames\BigCitiesSource;
use Wokis\Geonames\JsonConverter;

include_once 'vendor/autoload.php';

$startTime = microtime(true);

$converter = new JsonConverter();
$converter->source(new CountryInfoSource('countryInfo.txt'));
$converter->convert('dist/countries.json');

$endTime = microtime(true);

$execTime = ($endTime - $startTime);

echo sprintf('All requested operations completed in <i>%s</i> seconds.', $execTime);
