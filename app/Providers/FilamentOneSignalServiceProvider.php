<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;

class FilamentOneSignalServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Filament::registerRenderHook(
            'head.end',
            fn(): string => <<<HTML
                <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
                <script>
                    window.OneSignal = window.OneSignal || [];
                    OneSignal.push(function() {
                        OneSignal.init({
                            appId: "YOUR-ONESIGNAL-APP-ID",
                            notifyButton: {
                                enable: true,
                            },
                            allowLocalhostAsSecureOrigin: true
                        });
                    });
                </script>
            HTML
        );
    }
}
