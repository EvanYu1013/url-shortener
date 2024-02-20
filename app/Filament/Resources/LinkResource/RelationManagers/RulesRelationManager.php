<?php

declare(strict_types=1);

namespace App\Filament\Resources\LinkResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class RulesRelationManager extends RelationManager
{
    protected static string $relationship = 'rules';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->required()
                    ->options([
                        'platform' => __('Platform'),
                        'browser' => __('Browser'),
                        'device' => __('Device'),
                        'country' => __('Country'),
                        'city' => __('City'),
                        'referer' => __('Referer'),
                        'ip' => __('IP'),
                        'fingerprint' => __('Fingerprint'),
                    ]),
                Forms\Components\TextInput::make('value')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('priority')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('target_url')
                    ->required()
                    ->url(),
                Forms\Components\Toggle::make('status')
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('type')
            ->columns([
                Tables\Columns\TextColumn::make('priority')
                    ->numeric(),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('value'),
                Tables\Columns\TextColumn::make('target_url'),
                Tables\Columns\ToggleColumn::make('status'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
