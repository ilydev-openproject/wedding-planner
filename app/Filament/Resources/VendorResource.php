<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Vendor;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\VendorResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\VendorResource\RelationManagers;

class VendorResource extends Resource
{
    protected static ?string $model = Vendor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('user_id')->default(auth()->id()),

                TextInput::make('name')->label('Nama Vendor')->required(),
                Select::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->preload()
                    ->searchable()
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
                    ])
                    ->required(),
                TextInput::make('contact')->label('Kontak')->nullable(),

                Textarea::make('notes')->label('Catatan')->rows(3)->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Vendor')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Kategori'),

                TextColumn::make('contact')
                    ->label('Kontak'),

                TextColumn::make('updated_at')
                    ->label('Diubah')
                    ->since(), // atau ->dateTime('d M Y')
            ])
            ->defaultSort('updated_at', 'desc')
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
            'index' => Pages\ListVendors::route('/'),
            // 'create' => Pages\CreateVendor::route('/create'),
            // 'edit' => Pages\EditVendor::route('/{record}/edit'),
        ];
    }
}
