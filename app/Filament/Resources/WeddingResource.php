<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WeddingResource\Pages;
use App\Filament\Resources\WeddingResource\RelationManagers;
use App\Models\Wedding;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WeddingResource extends Resource
{
    protected static ?string $model = Wedding::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    protected static ?string $navigationLabel = 'Weddings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Wedding Name'),
                Forms\Components\DatePicker::make('date')
                    ->required()
                    ->after('today')
                    ->label('Wedding Date')
                    ->native(false),
                Forms\Components\TextInput::make('location')
                    ->required()
                    ->maxLength(255)
                    ->label('Location'),
                Forms\Components\Select::make('tradition')
                    ->options([
                        'Jawa' => 'Jawa',
                        'Sunda' => 'Sunda',
                        'Bali' => 'Bali',
                        'Minang' => 'Minang',
                        'Batak' => 'Batak',
                    ])
                    ->native(false)
                    ->label('Tradition'),
                Hidden::make('user_id')
                    ->default(auth()->id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Wedding Name'),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable()
                    ->label('Date'),
                Tables\Columns\TextColumn::make('location')
                    ->searchable()
                    ->label('Location'),
                Tables\Columns\TextColumn::make('tradition')
                    ->label('Tradition'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Owner')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tradition')
                    ->options([
                        'Jawa' => 'Jawa',
                        'Sunda' => 'Sunda',
                        'Bali' => 'Bali',
                        'Minang' => 'Minang',
                        'Batak' => 'Batak',
                    ])
                    ->label('Filter by Tradition'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->visible(fn($record) => auth()->user()->hasRole('admin') || auth()->user()->id === $record->user_id),
                Tables\Actions\DeleteAction::make()->visible(fn($record) => auth()->user()->hasRole('admin') || auth()->user()->id === $record->user_id),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWeddings::route('/'),
            'create' => Pages\CreateWedding::route('/create'),
            'edit' => Pages\EditWedding::route('/{record}/edit'),
        ];
    }
}
