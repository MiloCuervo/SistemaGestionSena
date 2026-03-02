<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Cases;

class CaseCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $processes,
        public $contacts,
        public ?Cases $case = null,
        public bool $readonly = false
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.case-card');
    }
}
