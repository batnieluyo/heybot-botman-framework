<?php

namespace App\Providers;

use App\Http\Controllers\Webhook\WhatsAppController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class WhatsAppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerWebhookRoutes();
    }

    protected function registerWebhookRoutes()
    {
        Route::withoutMiddleware(\Illuminate\Session\Middleware\StartSession::class)
            ->middleware(['throttle:webhook'])
            ->name('webhook.')
            ->prefix('webhook')
            ->group(function () {
                Route::post('/whatsapp', [WhatsappController::class, 'store']);
            });
    }
}
