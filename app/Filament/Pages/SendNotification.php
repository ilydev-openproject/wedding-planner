<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class SendNotification extends Page
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-bell';
    protected static string $view = 'filament.pages.send-notification';
    protected static ?string $navigationLabel = 'Kirim Notifikasi';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('title')
                ->label('Judul Notifikasi')
                ->required(),
            Textarea::make('message')
                ->label('Pesan')
                ->required(),
        ];
    }

    protected function getFormModel(): string
    {
        return self::class;
    }

    public function submit()
    {
        $data = $this->form->getState();

        // Kirim ke OneSignal
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . env('ONESIGNAL_REST_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://onesignal.com/api/v1/notifications', [
                    'app_id' => env('ONESIGNAL_APP_ID'),
                    'included_segments' => ['All'],
                    'headings' => ['en' => $data['title']],
                    'contents' => ['en' => $data['message']],
                ]);

        if ($response->successful()) {
            \Filament\Notifications\Notification::make()
                ->title('Sukses!')
                ->body('Notifikasi berhasil dikirim.')
                ->success()
                ->send();
        } else {
            \Filament\Notifications\Notification::make()
                ->title('Gagal!')
                ->body('Gagal mengirim notifikasi.')
                ->danger()
                ->send();
        }
    }
}
