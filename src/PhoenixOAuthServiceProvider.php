<?php

namespace TobyMaxham\PhoenixSocialite;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;

class PhoenixOAuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $socialite = $this->app->make(\Laravel\Socialite\Contracts\Factory::class);
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
