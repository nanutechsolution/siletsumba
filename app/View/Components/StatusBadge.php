<?php

namespace App\View\Components;

use Illuminate\View\Component;

class StatusBadge extends Component
{
    public string $status;
    public $scheduledAt;

    public function __construct(string $status, $scheduledAt = null)
    {
        $this->status = $status;
        $this->scheduledAt = $scheduledAt;
    }

    public function render()
    {
        return view('components.status-badge');
    }
}
