<?php

declare(strict_types=1);

namespace App\Filament\Resources\ScriptResource\Pages;

use App\Filament\Resources\ScriptResource;
use Filament\Resources\Pages\CreateRecord;

class CreateScript extends CreateRecord
{
    protected static string $resource = ScriptResource::class;
}
