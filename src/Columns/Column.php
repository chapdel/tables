<?php

namespace Filament\Tables\Columns;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;
use Illuminate\View\Component;

class Column extends Component implements Htmlable
{
    use Concerns\BelongsToTable;
    use Concerns\CanBeHidden;
    use Concerns\CanBeSearchable;
    use Concerns\CanBeSortable;
    use Concerns\CanCallAction;
    use Concerns\CanCountRelatedModels;
    use Concerns\CanOpenUrl;
    use Concerns\EvaluatesClosures;
    use Concerns\HasAlignment;
    use Concerns\HasExtraAttributes;
    use Concerns\HasExtraHeaderAttributes;
    use Concerns\HasLabel;
    use Concerns\HasName;
    use Concerns\HasRecord;
    use Concerns\HasState;
    use Concerns\HasView;
    use Concerns\InteractsWithTableQuery;
    use Conditionable;
    use Macroable;
    use Tappable;

    final public function __construct(string $name)
    {
        $this->name($name);
    }

    public static function make(string $name): static
    {
        $static = app(static::class, ['name' => $name]);
        $static->setUp();

        return $static;
    }

    protected function setUp(): void
    {
    }

    public function toHtml(): string
    {
        return $this->render()->render();
    }

    public function render(): View
    {
        return view($this->getView(), array_merge($this->data(), [
            'column' => $this,
        ]));
    }
}
