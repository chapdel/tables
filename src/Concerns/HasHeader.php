<?php

namespace Filament\Tables\Concerns;

use Closure;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;

trait HasHeader
{
    protected array $cachedTableHeaderActions;

    public function cacheTableHeaderActions(): void
    {
        $this->cachedTableHeaderActions = collect($this->getTableHeaderActions())
            ->mapWithKeys(function (Action $action): array {
                $action->table($this->getCachedTable());

                return [$action->getName() => $action];
            })
            ->toArray();
    }

    public function getCachedTableHeaderActions(): array
    {
        return collect($this->cachedTableHeaderActions)
            ->filter(fn (Action $action): bool => ! $action->isHidden())
            ->toArray();
    }

    protected function getCachedTableHeaderAction(string $name): ?Action
    {
        return $this->getCachedTableHeaderActions()[$name] ?? null;
    }

    protected function getTableDescription(): ?string
    {
        return null;
    }

    protected function getTableHeader(): ?View
    {
        return null;
    }

    protected function getTableHeaderActions(): array
    {
        return [];
    }

    protected function getTableHeading(): string | Closure | null
    {
        return null;
    }
}
