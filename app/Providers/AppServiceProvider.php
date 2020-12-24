<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Jenssegers\Agent\Agent;
use Auth;
use DB;
use Log;
use File;
use App\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'account');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'category');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'type');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'payment');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'setting');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'admin');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'gift');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        View::share('config', getConfig('general'));
        View::share('logo', asset(getLogo()));
        $agent = new Agent();
        View::share('agent', $agent);
        // get current uri
        $current = request()->getRequestUri();
        // check has alert
        $alert = checkAlert($current);
        if ($alert) {
            View::share('alert', $alert);
        }
        View::share('messenger', $this->getMessenger());
    }

    private function getMessenger()
    {
        $messenger = Setting::where('key', config('setting.MESSENGER'))->first();
        if (!$messenger) {
            return '';
        }
        return $messenger->value;
    }
}
