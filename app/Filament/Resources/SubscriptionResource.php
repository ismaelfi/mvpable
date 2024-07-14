<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriptionResource\Pages;
use App\Models\Subscription;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required(),
                Forms\Components\TextInput::make('type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('stripe_id')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('stripe_status')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('stripe_price')
                    ->maxLength(255),
                Forms\Components\TextInput::make('quantity'),
                Forms\Components\DateTimePicker::make('trial_ends_at'),
                Forms\Components\DateTimePicker::make('ends_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id')->sortable()->searchable(),
                TextColumn::make('type')->sortable()->searchable(),
                TextColumn::make('stripe_id')->sortable()->searchable(),
                TextColumn::make('stripe_status')
                    ->badge()
                    ->sortable()
                    ->colors([
                        'danger' => 'canceled',
                        'success' => 'active',
                        'warning' => 'past_due',
                    ]),
                TextColumn::make('stripe_price')->sortable(),
                TextColumn::make('amount')->sortable(),
                TextColumn::make('quantity')->sortable(),
                TextColumn::make('trial_ends_at')->dateTime(),
                TextColumn::make('ends_at')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscriptions::route('/'),
            'edit' => Pages\EditSubscription::route('/{record}/edit'),
        ];
    }
}
