<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Guest;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\GuestResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\GuestResource\RelationManagers;

class GuestResource extends Resource
{
    protected static ?string $model = Guest::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Tamu Undangan';

    protected static ?string $navigationGroup = 'Details';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('user_id')->default(auth()->id()),
                Select::make('wedding_id')
                    ->label('Acara Pernikahan')
                    ->relationship('wedding', 'wedding_title')
                    ->native(false)
                    ->required(),

                TextInput::make('name')
                    ->required()
                    ->label('Nama Tamu'),

                TextInput::make('phone')
                    ->tel()
                    ->label('No. HP')
                    ->nullable(),

                Select::make('status')
                    ->options([
                        'pending' => 'Belum Konfirmasi',
                        'confirmed' => 'Hadir',
                        'declined' => 'Tidak Hadir',
                    ])
                    ->native(false)
                    ->default('pending')
                    ->label('Status Kehadiran'),
                TextInput::make('number_of_people')  // Menambahkan input jumlah orang
                    ->label('Number of People')
                    ->minValue(1)  // Set minimal 1 orang
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('wedding.wedding_title')->label('Acara'),
                TextColumn::make('name')->label('Nama Tamu')->searchable(),
                TextColumn::make('phone')->label('Nomor HP'),
                TextColumn::make('number_of_people')  // Menampilkan jumlah orang
                    ->label('Jumlah orang')
                    ->sortable(),
                BadgeColumn::make('status')->label('Kehadiran')->colors([
                    'pending' => 'warning',
                    'confirmed' => 'success',
                    'declined' => 'danger',
                ]),
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
            'index' => Pages\ListGuests::route('/'),
            // 'create' => Pages\CreateGuest::route('/create'),
            // 'edit' => Pages\EditGuest::route('/{record}/edit'),
        ];
    }

}
