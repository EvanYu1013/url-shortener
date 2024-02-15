<?php

declare(strict_types=1);

namespace App\Filament\Resources\RequestLogResource\Pages;

use App\Filament\Resources\RequestLogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRequestLog extends CreateRecord
{
    protected static string $resource = RequestLogResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
