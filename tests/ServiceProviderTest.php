<?php

namespace TobyMaxham\PhoenixSocialite\Tests;

use Laravel\Socialite\Contracts\Factory;
use Laravel\Socialite\SocialiteServiceProvider;
use Orchestra\Testbench\TestCase;
use TobyMaxham\PhoenixSocialite\PhoenixOAuthProvider;
use TobyMaxham\PhoenixSocialite\PhoenixOAuthServiceProvider;

class ServiceProviderTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('services.phoenix-auth', [
            'instance' => 'http://instance.myinstance.local',
            'client_id' => 'phoenix-client-id',
            'client_secret' => 'phoenix-client-secret',
            'redirect' => 'http://your-callback-url',
            'token' => 'bearer-token',
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [
            PhoenixOAuthServiceProvider::class,
            SocialiteServiceProvider::class,
        ];
    }

    public function test_it_can_instantiate_the_phoenix_driver()
    {
        $factory = $this->app->make(Factory::class);

        $provider = $factory->driver('phoenix-auth');
        $this->assertInstanceOf(PhoenixOAuthProvider::class, $provider);
    }
}
