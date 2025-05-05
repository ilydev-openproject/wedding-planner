<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Checklist;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\BooleanColumn;
use App\Filament\Resources\ChecklistResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ChecklistResource\RelationManagers;

class ChecklistResource extends Resource
{
    protected static ?string $model = Checklist::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('user_id')->default(auth()->id()),

                TextInput::make('task')
                    ->label('Tugas')
                    ->required()
                    ->maxLength(255),

                DatePicker::make('due_date')
                    ->label('Batas Waktu')
                    ->nullable()
                    ->native(false),

                Toggle::make('is_done')
                    ->label('Selesai?')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('task')->label('Tugas')->searchable(),
                TextColumn::make('due_date')->label('Deadline')->date(),
                BooleanColumn::make('is_done')->label('Status'),
                TextColumn::make('created_at')->label('Dibuat')->dateTime('d M Y'),
                TextColumn::make('remaining_time')
                    ->label('Sisa Waktu')
                    ->state(function ($record) {
                        if (!$record->due_date)
                            return '-';

                        $due = Carbon::parse($record->due_date);
                        $now = Carbon::now();

                        if ($now->greaterThan($due)) {
                            return 'Lewat ' . $now->diffInDays($due) . ' hari';
                        }

                        $diff = $now->diff($due);

                        if ($diff->m === 0) {
                            return "{$diff->d} hari lagi";
                        }

                        return "{$diff->m} bulan {$diff->d} hari lagi";
                    }),

            ])
            ->defaultSort('due_date')
            ->filters([
                Filter::make('is_done')->label('Selesai')->query(fn($q) => $q->where('is_done', true)),
                Filter::make('belum_selesai')->label('Belum Selesai')->query(fn($q) => $q->where('is_done', false)),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChecklists::route('/'),
            // 'create' => Pages\CreateChecklist::route('/create'),
            // 'edit' => Pages\EditChecklist::route('/{record}/edit'),
        ];
    }
}
