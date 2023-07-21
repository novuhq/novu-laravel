<div align="center">
  <a href="https://novu.co" target="_blank">
  <picture>
    <source media="(prefers-color-scheme: dark)" srcset="https://user-images.githubusercontent.com/2233092/213641039-220ac15f-f367-4d13-9eaf-56e79433b8c1.png">
    <img src="https://user-images.githubusercontent.com/2233092/213641043-3bbb3f21-3c53-4e67-afe5-755aeb222159.png" width="280" alt="Logo"/>
  </picture>
  </a>
</div>

# Novu for Laravel

A package to easily integrate your Laravel application with Novu.

## Installation

[PHP](https://php.net) 7.2+ and [Composer](https://getcomposer.org) are required. Supports Laravel 7, 8, 9 and 10 out of the box.

To get the latest version of Novu Laravel, simply require it:

```bash
composer require novu/novu-laravel
```

## Configuration

You can publish the configuration file using this command:

```bash
php artisan vendor:publish --provider="Novu\Laravel\NovuServiceProvider" --tag="novu-laravel-config"
```

A configuration file named `novu.php` with some sensible defaults will be placed in your `config` directory:

```php
<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Novu API Key
    |--------------------------------------------------------------------------
    |
    | The Novu API key give you access to Novu's API. The "api_key" is
    | typically used to make a request to the API.
    |
    */
    'api_key' => env('NOVU_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | The Novu API Base URL.
    |--------------------------------------------------------------------------
    |
    | The Novu API Base URL can be a self-hosted novu api or Novu's web cloud API
    | typically used to make a request to Novu's service.
    |
    */
    'api_url' => env('NOVU_BASE_API_URL', 'https://api.novu.co/v1/'),
];
```
### API Keys
Open your `.env` file and add your API Key.

```php
NOVU_API_KEY=xxxxxxxxxxxxx
```

***Note:** You need to get these credentials from your [Novu Dashboard](https://web.novu.co/settings)*