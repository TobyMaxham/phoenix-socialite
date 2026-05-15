<?php

declare(strict_types=1);

namespace TobyMaxham\PhoenixSocialite;

use Laravel\Socialite\Two\User;
use GuzzleHttp\Exception\GuzzleException;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;

class PhoenixOAuthProvider extends AbstractProvider implements ProviderInterface
{
    public static string $PHOENIX_INSTANCE;

    protected function getAuthUrl($state): string
    {
        return $this->buildAuthUrlFromBase(self::$PHOENIX_INSTANCE.'/oauth2/authorize', $state);
    }

    /**
     * @throws GuzzleException
     */
    public function getAccessTokenResponse($code): array
    {
        $response = $this->getHttpClient()->post($this->getTokenUrl(), [
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer '.config('services.phoenix-auth.token'),
            ],
            'form_params' => $this->getTokenFields($code),
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    protected function getTokenUrl(): string
    {
        return self::$PHOENIX_INSTANCE.'/oauth2/access_token';
    }

    /**
     * @throws GuzzleException
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get(self::$PHOENIX_INSTANCE.'/api/userinfo', [
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer '.$token,
            ],
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    protected function mapUserToObject(array $user): User
    {
        return (new User)->setRaw($user)->map([
            'id'           => $user['id'],
            'nickname'     => $user['user']['firstname'],
            'name'         => $user['user']['firstname'].' '.$user['user']['lastname'],
            'email'        => $user['user']['email'],
            'birthday'     => $user['user']['birthday'],
            'organisation' => $user['organisation'],
            'avatar'       => null,
        ]);
    }
}
