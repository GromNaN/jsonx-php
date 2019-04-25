<?php

namespace JSONx;

/**
 * Converts any JSONx formatted element into its PHP data representation.
 *
 * @author Jérôme Tamarelle <jerome@tamarelle.net>
 *
 * @param DOMElement
 *
 * @return mixed
 */
function parse(\DOMElement $node)
{
    switch ($node->nodeName) {
        case 'json:object':
            $data = array();
            foreach ($node->childNodes as $childNode) {
                if ($childNode instanceof \DOMElement
                    && null !== $childNode->attributes
                    && $name = $childNode->attributes->getNamedItem('name')) {
                    $data[$name->nodeValue] = parse($childNode);
                }
            }
            break;
        case 'json:array':
            $data = array();
            foreach ($node->childNodes as $index => $childNode) {
                if ($childNode instanceof \DOMElement) {
                    $data[] = parse($childNode);
                }
            }
            break;
        case 'json:string':
            $data = $node->nodeValue;
            break;
        case 'json:html':
            $data = '';
            foreach ($node->childNodes as $childNode) {
                $data .= $node->ownerDocument->saveHTML($childNode);
            }
            break;
        case 'json:boolean':
            $data = 'true' == strtolower($node->nodeValue);
            break;
        case 'json:number':
            $data = (float) $node->nodeValue;
            break;
        case 'json:time':
            $data = strtotime($node->nodeValue);
            break;
        case 'json:null':
        default:
            $data = null;
    }

    return $data;
}
