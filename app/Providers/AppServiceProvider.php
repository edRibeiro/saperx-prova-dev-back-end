<?php

namespace App\Providers;

use App\Services\ContactServiceInterface;
use App\Services\Implements\ContactService;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            ContactServiceInterface::class,
            ContactService::class
        );
        $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('error', function ($message, $code = HttpResponse::HTTP_BAD_REQUEST) {
            return response()->json(['error' => $message], $code);
        });
    }
}
