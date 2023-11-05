<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class AttendanceHistoryWidget extends Widget
{
    protected static string $view = 'filament.widgets.attendance-history-widget';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 3;
}
