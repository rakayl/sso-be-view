<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Routing\UrlGenerator;
use MyHelper;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        if (env('REDIRECT_HTTPS', 'false') == 'true') {
            $url->forceScheme('https');
        }

        view()->composer('*', function ($view) {
                $view->with('configs', session('configs'));
                $view->with('grantedFeature', session('granted_features'));

                $badges = MyHelper::get('sidebar-badge?log_save=false')['result'] ?? [];
                View::share('sidebar_badges', $badges);
                View::share('total_inbox', 123);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('mailgun.client', function () {
            return \Http\Adapter\Guzzle6\Client::createWithConfig([
                // your Guzzle6 configuration
            ]);
        });
    }
}
