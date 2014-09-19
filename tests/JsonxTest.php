<?php

require __DIR__ . '/../src/jsonx.php';

/**
 * @author Jérôme Tamarelle <jerome@tamarelle.net>
 */
class JsonxTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getJsonxData
     */
    public function testParse($xml, $json)
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<json:object xsi:schemaLocation="http://www.datapower.com/schemas/json jsonx.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:json="http://www.ibm.com/xmlns/prod/2009/jsonx">
{$xml}
</json:object>
XML;
        $dom = new \DOMDocument();
        $dom->loadXML($xml);

        $this->assertEquals(json_decode('{'.$json.'}'), jsonx\parse($dom->documentElement));
    }

    public function getJsonxData()
    {
        return array(
            array(
                '<json:string name="Ticker">IBM</json:string>',
                '"Ticker" : "IBM"',
            ),
            array(
                '<json:array name="phoneNumbers"><json:string>212 555-1111</json:string><json:string>212 555-2222</json:string></json:array>',
                '"phoneNumbers": [ "212 555-1111", "212 555-2222" ]',
            ),
            array(
                '<json:boolean name="remote">false</json:boolean>',
                '"remote": false',
            ),
            array(
                '<json:string name="name">John Smith</json:string>',
                '"name": "John Smith"',
            ),
            array(
                '<json:number name="height">62.4</json:number>',
                '"height": 62.4',
            ),
            array(
                '<json:null name="additionalInfo" />',
                '"additionalInfo": null',
            ),
            array(
'<json:string name="name">John Smith</json:string>
  <json:object name="address">
    <json:string name="streetAddress">21 2nd Street</json:string>
    <json:string name="city">New York</json:string>
    <json:string name="state">NY</json:string>
    <json:number name="postalCode">10021</json:number>
  </json:object>
  <json:array name="phoneNumbers">
    <json:string>212 555-1111</json:string>
    <json:string>212 555-2222</json:string>
  </json:array>
  <json:null name="additionalInfo" />
  <json:boolean name="remote">false</json:boolean>
  <json:number name="height">62.4</json:number>
  <json:string name="ficoScore"> > 640</json:string>',
' "name":"John Smith",
  "address": {
    "streetAddress": "21 2nd Street",
    "city": "New York",
    "state": "NY",
    "postalCode": 10021
  },
  "phoneNumbers": [
    "212 555-1111",
    "212 555-2222"
  ],
  "additionalInfo": null,
  "remote": false,
  "height": 62.4,
  "ficoScore": " > 640"',
            ),
        );
    }
}
