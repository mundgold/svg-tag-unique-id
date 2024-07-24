<?php

namespace Mundgold\SvgTagUniqueId\Tags;

use Illuminate\Support\Str;
use Statamic\Tags\Svg as BaseSvg;

class Svg extends BaseSvg
{
    public function index()
    {

        $svg = parent::index();
        if ($this->params->bool('replace_ids')) {
            $svg = $this->addFilenamePrefixToIds($svg);
        }

        return $svg;
    }

    protected function addFilenamePrefixToIds($svg)
    {
        $uniqPrefix = uniqid('svg_');
        $svg = Str::of($svg)->remove('replace_ids="true"');
        $doc = new \DOMDocument('1.0', 'UTF-8');
        $doc->loadXML(html_entity_decode($svg));

        $xpath = new \DOMXPath($doc);
        $xpath->registerNamespace('xlink', 'http://www.w3.org/1999/xlink');
        $nodes = $xpath->query('//*[@id]');

        foreach ($nodes as $node) {
            $oldId = $node->getAttribute('id');
            $newId = $uniqPrefix . '_' . $oldId;
            $node->setAttribute('id', $newId);

            $clipPathNodes = $xpath->query('//*[@clip-path]');
            foreach ($clipPathNodes as $clipPathNode) {
                $clipPathValue = $clipPathNode->getAttribute('clip-path');
                $newClipPathValue = str_replace('url(#' . $oldId . ')', 'url(#' . $newId . ')', $clipPathValue);
                $clipPathNode->setAttribute('clip-path', $newClipPathValue);
            }

            $xlinkNodes = $xpath->query('//*[@xlink:href]');
            foreach ($xlinkNodes as $xlinkNode) {
                $xlinkValue = $xlinkNode->getAttribute('xlink:href');
                $newXlinkValue = str_replace('#' . $oldId, '#' . $newId, $xlinkValue);
                $xlinkNode->setAttribute('xlink:href', $newXlinkValue);
            }

            $fillNodes = $xpath->query('//*[@fill]');
            foreach ($fillNodes as $fillNode) {
                $fillValue = $fillNode->getAttribute('fill');
                $newFillValue = str_replace('url(#' . $oldId . ')', 'url(#' . $newId . ')', $fillValue);
                $fillNode->setAttribute('fill', $newFillValue);
            }
        }

        return $doc->saveHTML();
    }
}
