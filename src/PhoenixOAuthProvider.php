<?php

namespace TobyMaxham\PhoenixSocialite;

use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;

class PhoenixOAuthProvider extends AbstractProvider implements ProviderInterface
{
    public static $PHOENIX_INSTANCE = null;

    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(self::$PHOENIX_INSTANCE . '/oauth2/authorize', $state);
    }

    /**
     * Get the access token response for the given code.
     *
     * @param  string  $code
     * @return array
     */
    public function getAccessTokenResponse($code)
    {
        $response = $this->getHttpClient()->post($this->getTokenUrl(), [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.config('services.phoenix-auth.token'),
            ],
               'form_params' => $this->getTokenFields($code),
        ]);

        return json_decode($response->getBody(), true);
    }

    protected function getTokenUrl()
    {
        return self::$PHOENIX_INSTANCE . '/oauth2/access_token';
    }

    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get(self::$PHOENIX_INSTANCE . '/api/userinfo', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$token,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id' => $user['id'],
            'nickname' => $user['user']['firstname'],
            'name' => $user['user']['firstname'].' '.$user['user']['lastname'],
            'email' => $user['user']['email'],
            'birthday' => $user['user']['birthday'],
            'organisation' => $user['organisation'],
            'avatar' => null,
        ]);
    }
}
