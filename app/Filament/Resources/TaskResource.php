<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Filament\Resources\TaskResource\RelationManagers;
use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('wedding_id')
                    ->relationship('wedding', 'name')
                    ->required()
                    ->label('Wedding Event')
                    ->default(fn() => auth()->user()->wedding()->first()?->id)
                    ->disabled(fn() => !auth()->user()->hasRole('admin'))
                    ->dehydrated(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('Task Title'),
                Forms\Components\Select::make('category')
                    ->options([
                        'seserahan' => 'Seserahan',
                        'siraman' => 'Siraman',
                        'akad' => 'Akad',
                        'resepsi' => 'Resepsi',
                        'lainnya' => 'Lainnya',
                    ])
                    ->required()
                    ->label('Category'),
                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('due_date')
                    ->required()
                    ->label('Due Date'),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                    ])
                    ->required()
                    ->label('Status'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}
