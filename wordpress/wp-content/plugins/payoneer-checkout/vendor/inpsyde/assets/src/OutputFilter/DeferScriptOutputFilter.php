<?php

declare (strict_types=1);
namespace Syde\Vendor\Inpsyde\Assets\OutputFilter;

use Syde\Vendor\Inpsyde\Assets\FilterAwareAsset;
/**
 * @deprecated use Asset::withAttributes(['defer' => true']);
 */
class DeferScriptOutputFilter implements AssetOutputFilter
{
    public function __invoke(string $html, FilterAwareAsset $asset): string
    {
        return str_replace('<script ', '<script defer ', $html);
    }
}
