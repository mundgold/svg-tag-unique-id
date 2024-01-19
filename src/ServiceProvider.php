<?php

namespace Mundgold\SvgTagUniqueId;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $tags = [
        Tags\Svg::class,
    ];
    public function bootAddon()
    {
        //
    }
}
