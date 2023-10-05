JSONX for PHP
=============

JSONx is a standard to represent JSON as XML.

You can read the [documentation on IBM website](https://www.ibm.com/docs/fr/datapower-gateway/10.5.x?topic=20-jsonx).

Features
--------

* Convert any `DOMNode` of JSONx into PHP data that can be JSON encoded.

Install
-------

    composer require grom/jsonx

Usage
-----

```php
// load jsonx file ...
require_once __DIR__.'/../src/jsonx.php';

// or use composer
require 'vendor/autoload.php';

$xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<json:object xsi:schemaLocation="http://www.datapower.com/schemas/json jsonx.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:json="http://www.ibm.com/xmlns/prod/2009/jsonx">
    <json:boolean name="remote">false</json:boolean>
    <json:number name="height">62.4</json:number>
    <json:time name="date">2015-08-29 15:07:00</json:time>
    <json:string name="ficoScore"> > 640</json:string>
</json:object>
XML;

$dom = new \DOMDocument();
$dom->loadXML($xml);

$data = JSONx\parse($dom->documentElement);

var_dump(json_encode($data));
/*
string(69) "{"remote":false,"height":62.4,"date":1440860820,"ficoScore":" > 640"}"
 */
```
