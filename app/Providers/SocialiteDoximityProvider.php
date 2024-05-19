<?php

namespace App\Providers;

use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;

use Illuminate\Support\Str;

class SocialiteDoximityProvider extends AbstractProvider implements ProviderInterface
{

    protected $scopes = ['openid',"profile:read:basic","profile:read:email"];

    protected $scopeSeparator = ' ';

    protected $usesPKCE = true;

    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(
            'https://auth.doximity.com/oauth/authorize',
            $state
        );
    }

    /**
     * Get the token URL for the provider.
     *
     * @return string
     */
    protected function getTokenUrl()
    {
        return 'https://auth.doximity.com/oauth/token';
    }

    /**
     * Get the raw user for the given access token.
     *
     * @param  string  $token
     * @return array
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get(
            'https://auth.doximity.com/oauth/userinfo',
            [
                'headers' => [
                    'Authorization' => 'Bearer '.$token,
                ],
            ]
        );

        $tokenParts = explode(".", $response->getBody());  
        $tokenHeader = base64_decode($tokenParts[0]);
        $tokenPayload = base64_decode($tokenParts[1]);
        $jwtHeader = json_decode($tokenHeader);
        $jwtPayload = json_decode($tokenPayload,true);

        return $jwtPayload;
        //return json_decode($response->getBody(), true);
    }

    /**
     * Map the raw user array to a Socialite User instance.
     *
     * @param  array  $user
     * @return \Laravel\Socialite\Two\User
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id'            => $user['sub'],
            'name'          => $user['name'],
            'email'         => $user['sub'].'@temp.findarotation.com',
            'avatar'        => $user['profile_photo_url'],
        ]);
    }

    /**
     * Get the POST fields for the token request.
     *
     * @param  string  $code
     * @return array
     */
    protected function getTokenFields($code)
    {
        return array_merge(parent::getTokenFields($code), [
            'grant_type' => 'authorization_code'
        ]);
    }
    
}
