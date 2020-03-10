<?php


namespace Hanson\LaravelAdminAlioss;


use Encore\Admin\Extension;

class Alioss extends Extension
{
    public $views = __DIR__ . '/../resources/views';

    public $assets = __DIR__ . '/../resources/assets';

    public static function getPaths($request)
    {
        return array_filter(explode(',', $request));
    }
}
