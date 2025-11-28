<?php

declare (strict_types=1);
namespace Syde\Vendor\Inpsyde\Assets\Loader;

use Syde\Vendor\Inpsyde\Assets\Asset;
interface LoaderInterface
{
    /**
     * @param mixed $resource
     *
     * @return Asset[]
     *
     * phpcs:disable Syde.Functions.ArgumentTypeDeclaration.NoArgumentType
     */
    public function load($resource): array;
}
