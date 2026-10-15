<?php

namespace App\Providers;

use App\Models\ContactSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View as ViewContract;
use SocialiteProviders\Authentik\Provider as AuthentikProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;

class AppServiceProvider extends ServiceProvider
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
        Event::listen(function (SocialiteWasCalled $event): void {
            $event->extendSocialite('authentik', AuthentikProvider::class);
        });

        View::composer('components.site-footer', function (ViewContract $view): void {
            $view->with('contactSetting', ContactSetting::query()->firstOrFail());
        });

        Paginator::useBootstrapFive();
    }
}
