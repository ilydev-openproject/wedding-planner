<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Checklist;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Kreait\Firebase\Contract\Messaging;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\BooleanColumn;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use App\Filament\Resources\ChecklistResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification as filNotif;
use App\Filament\Resources\ChecklistResource\RelationManagers;

class ChecklistResource extends Resource
{
    protected static ?string $model = Checklist::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationGroup = 'Details';

    protected static ?int $navigationSort = 2;

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
                Tables\Actions\DeleteAction::make(),
                Action::make('sendNotification')
                    ->label('Kirim Notifikasi')
                    ->action(function () {
                        $messaging = app(Messaging::class);
                        $topic = 'your-topic'; // Ganti dengan topik Anda
                        $title = 'Notifikasi Baru';
                        $body = 'Ini adalah pesan notifikasi';

                        $message = CloudMessage::withTarget('topic', $topic)
                            ->withNotification(Notification::create($title, $body));

                        $messaging->send($message);

                        filNotif::make()
                            ->title('Notifikasi Terkirim!')
                            ->success()
                            ->send();
                    }),
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
