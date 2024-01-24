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
        $doc = new \DOMDocument();
        $doc->loadXML($svg);

        $xpath = new \DOMXPath($doc);
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
        }

        return $doc->saveHTML();
    }
}
