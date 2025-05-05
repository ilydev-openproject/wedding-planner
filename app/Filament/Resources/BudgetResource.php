<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Budget;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BudgetResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BudgetResource\RelationManagers;

class BudgetResource extends Resource
{
    protected static ?string $model = Budget::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('user_id')->default(auth()->id()),

                Select::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name', fn($query) => $query->where('is_for_budget', true))
                    ->searchable()
                    ->required()
                    ->preload()
                    ->dehydrated()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->label('Nama Kategori')
                            ->required()
                            ->maxLength(255),

                        Toggle::make('is_for_vendor')
                            ->label('Untuk Vendor?')
                            ->default(false),

                        Toggle::make('is_for_budget')
                            ->label('Untuk Budget?')
                            ->default(false),
                        Hidden::make('user_id')
                            ->default(auth()->id()),
                    ]),

                TextInput::make('estimated')
                    ->label('Estimasi Biaya')
                    ->numeric()
                    ->required()
                    ->prefix('Rp'),

                TextInput::make('actual')
                    ->label('Realisasi')
                    ->numeric()
                    ->default(0)
                    ->prefix('Rp'),

                Textarea::make('notes')
                    ->label('Catatan')
                    ->rows(2)
                    ->nullable(),
                Select::make('vendor_id')
                    ->label('Vendor Terkait')
                    ->relationship('vendor', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->searchable(),
                TextColumn::make('estimated')
                    ->label('Estimasi')
                    ->money('IDR'),
                TextColumn::make('actual')
                    ->label('Realisasi')
                    ->money('IDR'),
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->date(),
            ])
            ->filters([

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
            'index' => Pages\ListBudgets::route('/'),
            // 'create' => Pages\CreateBudget::route('/create'),
            // 'edit' => Pages\EditBudget::route('/{record}/edit'),
        ];
    }
}
