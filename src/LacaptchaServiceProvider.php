<?php

namespace CrazyInventor\Lacaptcha;

use Illuminate\Support\ServiceProvider;

class LacaptchaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap
     */
    public function boot()
    {
        // Add a validation rule called 'recaptcha' to be used for form validation
        $app = $this->app;
        $app['validator']->extend('recaptcha', function ($attribute, $value) use ($app) {
            return $app['recaptcha']->verify($value, $app['request']->getClientIp()) == true;
        });
        // make config file installable
        $this->publishes([
            __DIR__.'/../config/recaptcha.php' => config_path('recaptcha.php'),
        ], 'config');
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
                config('recaptcha.sitekey'),
                config('recaptcha.secret')
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
