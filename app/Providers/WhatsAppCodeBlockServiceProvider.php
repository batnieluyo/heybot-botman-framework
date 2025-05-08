<?php

namespace App\Providers;

use App\Http\Controllers\CodeBlockController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class WhatsAppCodeBlockServiceProvider extends ServiceProvider
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
        if (app()->isLocal()) {
            $this->registerRoutes();
        }
    }

    protected function registerRoutes()
    {
        Route::withoutMiddleware(\Illuminate\Session\Middleware\StartSession::class)
            ->middleware(['throttle:webhook'])
            ->name('repl.')
            ->prefix('repl')
            ->group(function () {
                Route::get('/whatsapp', [CodeBlockController::class, 'index']);
                Route::get('/whatsapp/{messageTypeId}', [CodeBlockController::class, 'show'])->name('whatsapp.message-type.show');
            });
    }
}
