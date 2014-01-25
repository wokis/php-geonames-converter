php-geonames-converter
======================

Format converter for geonames dump files

Geonames dump files
-------------------
All the geonames dump files can be found at http://download.geonames.org/export/dump/

They are licensed under to the [Creative Commons Attribution 3.0](http://creativecommons.org/licenses/by/3.0/) license.

Configuration
-------------

The file ``index.php`` contains sample code for conversion of ``countryInfo.txt`` and ``allCountries.txt``. 

The sample output of the JSON converter can be found in ``dist/countryInfo.json``.

Currently the JSON converter is the only one implemented.

Sample code to get you running:

```php
<?php

use Wokis\Geonames\CountryInfoSource;
use Wokis\Geonames\JsonConverter;

include_once 'vendor/autoload.php';

$converter = new JsonConverter();
$converter->source(new CountryInfoSource('countryInfo.txt'));
$converter->convert('dist/countries.json');
```

Import all the source and converter classes, define the correct namespace or use the correct namespace directly. **Be sure to use the autoloader to load the correct classes**.

Usage
-----
Simply call or browse to ``index.php``. 

It's recommended to start the conversion using the command line (CLI) version of PHP. 

```$ php index.php```

This is because if a large file is converted the process might trip  PHP's ``max_execution_time``. Also the web server can have other timeout configurations that may interrupt the conversion process. See the [PHP manual](http://www.php.net/manual/en/info.configuration.php#ini.max-execution-time) for more information.