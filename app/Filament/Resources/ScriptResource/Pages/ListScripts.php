<?php

declare(strict_types=1);

namespace App\Filament\Resources\ScriptResource\Pages;

use App\Filament\Resources\ScriptResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListScripts extends ListRecords
{
    protected static string $resource = ScriptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
