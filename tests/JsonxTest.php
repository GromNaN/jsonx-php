<?php

/**
 * @author Jérôme Tamarelle <jerome@tamarelle.net>
 */
class JsonxTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getTestData
     */
    public function testParse($file, $test, $xml, $json)
    {
        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = false;
        $dom->loadXML($xml);

        $data = JSONx\parse($dom->documentElement);

        $this->assertEquals(json_decode($json, true), $data, $test);
    }

    public function getTestData()
    {
        $files = glob(__DIR__.'/fixtures/*.test');

        $tests = array();

        foreach ($files as $file) {
            if (preg_match('/^--TEST--\s*(.*?)\s*--XML--\s*(.*?)\s*--JSON--\s*(.*?)\s*$/sx', file_get_contents($file), $matches)) {
                $tests[] = array(
                    basename($file),
                    $matches[1],
                    $matches[2],
                    $matches[3],
                );
            } else {
                throw new \RuntimeException('Invalid test case: '.str_replace(__DIR__.'/', '', $file));
            }
        }

        return $tests;
    }
}
