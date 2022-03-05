<?php

namespace Filament\Tables\Concerns;

use Filament\Tables\Columns\Column;

trait HasColumns
{
    protected array $cachedTableColumns;

    public function cacheTableColumns(): void
    {
        $this->cachedTableColumns = collect($this->getTableColumns())
            ->mapWithKeys(function (Column $column): array {
                $column->table($this->getCachedTable());

                return [$column->getName() => $column];
            })
            ->toArray();
    }

    public function callTableColumnAction(string $name, string $recordKey)
    {
        $record = $this->resolveTableRecord($recordKey);

        if (! $record) {
            return;
        }

        $column = $this->getCachedTableColumn($name);

        if (! $column) {
            return;
        }

        if ($column->isHidden()) {
            return;
        }

        return $column->record($record)->callAction();
    }

    public function getCachedTableColumns(): array
    {
        return collect($this->cachedTableColumns)
            ->filter(fn (Column $column): bool => ! $column->isHidden())
            ->toArray();
    }

    protected function getCachedTableColumn(string $name): ?Column
    {
        return $this->getCachedTableColumns()[$name] ?? null;
    }

    protected function getTableColumns(): array
    {
        return [];
    }
}
