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
                            appId: "bee43dc7-0fee-4dc4-a338-3d9f2abb755c",
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
