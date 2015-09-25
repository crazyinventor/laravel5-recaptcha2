<?php

namespace CrazyInventor\Lacaptcha;

use CrazyInventor\Lacaptcha\Lacaptcha;
use Illuminate\Support\ServiceProvider;

class LacaptchaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap
     */
    public function boot()
    {
        $app = $this->app;
        $app['validator']->extend('recaptcha', function ($attribute, $value) use ($app) {
            return $app['recaptcha']->verifyResponse($value, $app['request']->getClientIp());
        });
        if ($app->bound('form')) {
            $app['form']->macro('recaptcha', function ($attributes = []) use ($app) {
                return $app['recaptcha']->display($attributes, $app->getLocale());
            });
        }
    }
    
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('recaptcha', function ($app) {
            return new Lacaptcha(
                env('RECAPTCHA_SITEKEY', ''),
                env('RECAPTCHA_SECRET', '')
            );
        });
    }
    
    /**
     * Get the service provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['recaptcha'];
    }
}
