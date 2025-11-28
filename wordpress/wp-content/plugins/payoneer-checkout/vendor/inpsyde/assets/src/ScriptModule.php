<?php

declare (strict_types=1);
namespace Syde\Vendor\Inpsyde\Assets;

use Syde\Vendor\Inpsyde\Assets\Handler\ScriptModuleHandler;
class ScriptModule extends BaseAsset implements Asset
{
    use DependencyExtractionTrait;
    /**
     * {@inheritDoc}
     */
    protected function defaultHandler(): string
    {
        return ScriptModuleHandler::class;
    }
    /**
     * {@inheritDoc}
     */
    public function version(): ?string
    {
        $this->resolveDependencyExtractionPlugin();
        return parent::version();
    }
    /**
     * {@inheritDoc}
     */
    public function dependencies(): array
    {
        $this->resolveDependencyExtractionPlugin();
        return parent::dependencies();
    }
}
