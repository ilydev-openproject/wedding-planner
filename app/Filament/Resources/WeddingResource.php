<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Wedding;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\WeddingResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\WeddingResource\RelationManagers;

class WeddingResource extends Resource
{
    protected static ?string $model = Wedding::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('user_id')->default(auth()->id()),
                TextInput::make('bride_name')->required(),
                TextInput::make('groom_name')->required(),
                TextInput::make('wedding_title'),
                DatePicker::make('wedding_date')->required()
                    ->native(false),
                TextInput::make('venue'),
                Textarea::make('notes'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('bride_name')->searchable(),
                TextColumn::make('groom_name')->searchable(),
                TextColumn::make('wedding_title')->label('Title'),
                TextColumn::make('wedding_date')->date(),
                TextColumn::make('venue'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
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
            // 'create' => Pages\CreateWedding::route('/create'),
            // 'edit' => Pages\EditWedding::route('/{record}/edit'),
        ];
    }
}
