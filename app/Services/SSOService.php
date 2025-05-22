<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class SSOService
{
    protected $clientId;
    protected $clientSecret;
    protected $authorizeURL;
    protected $tokenURL;
    protected $apiURLBase;
    protected $redirectURL;

    public function __construct()
    {
        $this->clientId = config('sso.client_id');
        $this->clientSecret = config('sso.client_secret');
        $this->authorizeURL = config('sso.authorize_url');
        $this->tokenURL = config('sso.token_url');
        $this->apiURLBase = config('sso.api_url');
        $this->redirectURL = config('sso.redirect_url');
    }

    public function getClientId()
    {
        return $this->clientId;
    }

    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    public function getAuthorizeURL()
    {
        return $this->authorizeURL;
    }

    public function getTokenURL()
    {
        return $this->tokenURL;
    }

    public function getApiURLBase()
    {
        return $this->apiURLBase;
    }

    public function getRedirectURL()
    {
        return $this->redirectURL;
    }

    public function getAccessToken($code)
    {
        $response = Http::withoutVerifying()->asForm()->post($this->tokenURL, [
            'grant_type' => 'authorization_code',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri' => $this->redirectURL,
            'code' => $code
        ]);

        return $response->json();
    }

    public function getUserInfo($accessToken)
    {
        $response = Http::withoutVerifying()->withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Accept' => 'application/json'
        ])->get($this->apiURLBase . 'user');

        return $response->json();
    }

    public function validateState($state)
    {
        return Session::get('sso_state') === $state;
    }
} 