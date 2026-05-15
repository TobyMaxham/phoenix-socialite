<?php

declare(strict_types=1);

namespace TobyMaxham\PhoenixSocialite;

use Throwable;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\Factory;
use Illuminate\Contracts\Container\BindingResolutionException;

class PhoenixOAuthServiceProvider extends ServiceProvider
{
    /**
     * @throws BindingResolutionException
     * @throws Throwable
     */
    public function boot(): void
    {
        $socialite = $this->app->make(Factory::class);
        $socialite->extend(
            'phoenix-auth',
            function ($app) use ($socialite) {
                throw_if(null == $app['config']['services.phoenix-auth'], 'PhoenixII config is missing: `config.services.phoenix-auth`!');
                $config = $app['config']['services.phoenix-auth'];

                throw_if(null == ($phoenixInstance = Arr::get($config, 'instance')), 'PhoenixII instance is missing!');
                PhoenixOAuthProvider::$PHOENIX_INSTANCE = $phoenixInstance;

                return $socialite->buildProvider(PhoenixOAuthProvider::class, $config);
            }
        );
    }
}
