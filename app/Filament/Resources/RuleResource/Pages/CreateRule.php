<?php

declare(strict_types=1);

namespace App\Filament\Resources\RuleResource\Pages;

use App\Filament\Resources\RuleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRule extends CreateRecord
{
    protected static string $resource = RuleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
