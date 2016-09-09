# laravel5-recaptcha2

Recaptcha v2 for Laravel 5. Inspired by [anhskohbo/no-captcha](https://github.com/anhskohbo/no-captcha) and [greggilbert/recaptcha](https://github.com/greggilbert/recaptcha).

## Installation

Run 'composer require crazyinventor/laravel5-recaptcha2' or modify your composer.json:
```json
{
    "require": {
        "crazyinventor/laravel5-recaptcha2": "1.0.1"
    }
}
```

## Configuration

Get your keys for recaptcha from the [admin page](https://www.google.com/recaptcha/admin#list). Add `RECAPTCHA_SECRET` and `RECAPTCHA_SITEKEY` to your **.env** file:
```
RECAPTCHA_SECRET=[secret-key]
RECAPTCHA_SITEKEY=[site-key]
```
Replace `[secret-key]` and `[site-key]` with your keys.

You can also hardcode the configuration. First publish the `recaptcha` configuration file by running the following command from a shell inside your Laravel's installation directory:

```
php artisan vendor:publish
```

This will create the file `config/recaptcha.php` in your Laravel's installation directory. Modify that file by entering your sitekey and secret.

#### Laravel 5.0

In `/config/app.php`, add the following to `providers`:
```
'CrazyInventor\Lacaptcha\LacaptchaServiceProvider',
```
and the following to `aliases`:
```
'Recaptcha' => 'CrazyInventor\Lacaptcha\Facades\Lacaptcha',
```

#### Laravel 5.1 and newer

In `/config/app.php`, add the following to `providers`:
```
CrazyInventor\Lacaptcha\LacaptchaServiceProvider::class,
```
and the following to `aliases`:
```
'Recaptcha' => CrazyInventor\Lacaptcha\Facades\Lacaptcha::class,
```

## Usage

1. In your form, use `{!! Recaptcha::render() !!}` to echo out the markup.
2. To validate your form, add the following rule:
```php
$rules = [
    // ...
    'g-recaptcha-response' => 'required|recaptcha',
];
```

## Testing

When testing your application you might want to skip the recaptcha part. To do so add these lines at the start of your test:
```php
// prevent validation error on captcha
Recaptcha::shouldReceive('verify')
    ->once()
    ->andReturn(true);
// provide hidden input for your 'required' validation
Recaptcha::shouldReceive('render')
    ->zeroOrMoreTimes()
    ->andReturn('<input type="hidden" name="g-recaptcha-response" value="1" />');
```
