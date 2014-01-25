<?php

// CSV files from http://download.geonames.org/export/dump/

ini_set('max_execution_time', 0);

use Wokis\Geonames\CountryInfoSource;
use Wokis\Geonames\AllCountriesSource;
use Wokis\Geonames\JsonConverter;

include_once 'vendor/autoload.php';

$startTime = microtime(true);

$converter = new JsonConverter();
$converter->source(new CountryInfoSource('countryInfo.txt'));
$converter->convert('dist/countries.json');

/** 
 * allCountries.txt is a very large file. Converting it will take a lot of time,
 *  therefore it's commented out
 */
//$converter = new JsonConverter();
//$converter->source(new AllCountriesSource('allCountries.txt'));
//$converter->convert('dist/allCountries.json');

$endTime = microtime(true);

$execTime = ($endTime - $startTime);

$hours = floor($execTime / 3600);
$minutes = floor(($execTime - ($hours*3600)) / 60);
$seconds = floor($execTime % 60);

echo sprintf('All requested operations completed in <i>%s</i> hour(s), <i>%s</i> minute(s) and <i>%s</i> second(s).', $hours, $minutes, $seconds);
