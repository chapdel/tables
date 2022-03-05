<?php

namespace Filament\Tables;

use Closure;
use Filament\Forms\ComponentContainer;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;
use Illuminate\View\Component as ViewComponent;

class Table extends ViewComponent implements Htmlable
{
    use Concerns\BelongsToLivewire;
    use Macroable;
    use Tappable;

    protected ?View $contentFooter = null;

    protected ?string $description = null;

    protected ?View $emptyState = null;

    protected ?string $emptyStateDescription = null;

    protected ?string $emptyStateHeading = null;

    protected ?string $emptyStateIcon = null;

    protected ?string $filtersFormWidth = null;

    protected ?string $recordAction = null;

    protected ?Closure $getRecordUrlUsing = null;

    protected ?View $header = null;

    protected string | Closure | null $heading = null;

    protected bool $isPaginationEnabled = true;

    protected array $meta = [];

    protected string $model;

    protected ?array $recordsPerPageSelectOptions = null;

    final public function __construct(HasTable $livewire)
    {
        $this->livewire($livewire);
    }

    public static function make(HasTable $livewire): static
    {
        return app(static::class, ['livewire' => $livewire]);
    }

    public function description(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function emptyState(?View $view): static
    {
        $this->emptyState = $view;

        return $this;
    }

    public function emptyStateDescription(?string $description): static
    {
        $this->emptyStateDescription = $description;

        return $this;
    }

    public function emptyStateHeading(?string $heading): static
    {
        $this->emptyStateHeading = $heading;

        return $this;
    }

    public function emptyStateIcon(?string $icon): static
    {
        $this->emptyStateIcon = $icon;

        return $this;
    }

    public function enablePagination(bool $condition = true): static
    {
        $this->isPaginationEnabled = $condition;

        return $this;
    }

    public function contentFooter(?View $view): static
    {
        $this->contentFooter = $view;

        return $this;
    }

    public function filtersFormWidth(?string $width): static
    {
        $this->filtersFormWidth = $width;

        return $this;
    }

    public function recordAction(?string $action): static
    {
        $this->recordAction = $action;

        return $this;
    }

    public function getRecordUrlUsing(?Closure $callback): static
    {
        $this->getRecordUrlUsing = $callback;

        return $this;
    }

    public function header(?View $view): static
    {
        $this->header = $view;

        return $this;
    }

    public function heading(string | Closure | null $heading): static
    {
        $this->heading = $heading;

        return $this;
    }

    public function model(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function recordsPerPageSelectOptions(array $options): static
    {
        $this->recordsPerPageSelectOptions = $options;

        return $this;
    }

    public function getActions(): array
    {
        return $this->getLivewire()->getCachedTableActions();
    }

    public function getAllRecordsCount(): int
    {
        return $this->getLivewire()->getAllTableRecordsCount();
    }

    public function getBulkActions(): array
    {
        return $this->getLivewire()->getCachedTableBulkActions();
    }

    public function getColumns(): array
    {
        return $this->getLivewire()->getCachedTableColumns();
    }

    public function getContentFooter(): ?View
    {
        return $this->contentFooter;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getEmptyState(): ?View
    {
        return $this->emptyState;
    }

    public function getEmptyStateActions(): array
    {
        return $this->getLivewire()->getCachedTableEmptyStateActions();
    }

    public function getEmptyStateDescription(): ?string
    {
        return $this->emptyStateDescription;
    }

    public function getEmptyStateHeading(): string
    {
        return $this->emptyStateHeading ?? __('tables::table.empty.heading');
    }

    public function getEmptyStateIcon(): string
    {
        return $this->emptyStateIcon ?? 'heroicon-o-x';
    }

    public function getFilters(): array
    {
        return $this->getLivewire()->getCachedTableFilters();
    }

    public function getFiltersForm(): ComponentContainer
    {
        return $this->getLivewire()->getTableFiltersForm();
    }

    public function getFiltersFormWidth(): ?string
    {
        return $this->filtersFormWidth;
    }

    public function getHeader(): ?View
    {
        return $this->header;
    }

    public function getHeaderActions(): array
    {
        return $this->getLivewire()->getCachedTableHeaderActions();
    }

    public function getHeading(): ?string
    {
        return value($this->heading);
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getMountedAction(): ?Action
    {
        return $this->getLivewire()->getMountedTableAction();
    }

    public function getMountedActionForm(): ComponentContainer
    {
        return $this->getLivewire()->getMountedTableActionForm();
    }

    public function getMountedBulkAction(): ?BulkAction
    {
        return $this->getLivewire()->getMountedTableBulkAction();
    }

    public function getMountedBulkActionForm(): ComponentContainer
    {
        return $this->getLivewire()->getMountedTableBulkActionForm();
    }

    public function getRecords(): Collection | Paginator
    {
        return $this->getLivewire()->getTableRecords();
    }

    public function getRecordsPerPageSelectOptions(): array
    {
        return $this->recordsPerPageSelectOptions;
    }

    public function getRecordAction(): ?string
    {
        return $this->recordAction;
    }

    public function getRecordUrl(Model $record): ?string
    {
        $callback = $this->getRecordUrlUsing;

        if (! $callback) {
            return null;
        }

        return $callback($record);
    }

    public function getSortColumn(): ?string
    {
        return $this->getLivewire()->getTableSortColumn();
    }

    public function getSortDirection(): ?string
    {
        return $this->getLivewire()->getTableSortDirection();
    }

    public function isFilterable(): bool
    {
        return $this->getLivewire()->isTableFilterable();
    }

    public function isPaginationEnabled(): bool
    {
        return $this->isPaginationEnabled;
    }

    public function isSelectionEnabled(): bool
    {
        return $this->getLivewire()->isTableSelectionEnabled();
    }

    public function isSearchable(): bool
    {
        return $this->getLivewire()->isTableSearchable();
    }

    public function toHtml(): string
    {
        return $this->render()->render();
    }

    public function render(): View
    {
        return view('tables::index', array_merge($this->data(), [
            'table' => $this,
        ]));
    }
}
