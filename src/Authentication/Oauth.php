<?php
/**
 * Created by PhpStorm.
 * User: kilian
 * Date: 15/03/18
 * Time: 11:11
 */

namespace AccentLabs\TrackingSdk\Authentication;


use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp;
use GuzzleHttp\Exception\RequestException;
use AccentLabs\TrackingSdk\Exceptions\RequestExceptions;


/**
 * Class Oauth
 * @package AccentLabs\TrackingSdk\Authentication
 */
class Oauth
{
    /**
     * @var $user
     */
    private $user;

    /**
     * @var $password
     */
    private $password;

    /**
     * @var $clientId
     */
    private $clientId;

    /**
     * @var $clientSecret
     */
    private $clientSecret;

    /**
     * @var $token
     */
    public $token;

    /**
     * @var $tokenType
     */
    public $tokenType;

    /**
     * @var string $storagePath
     */
    private $storagePath = "sdk/";

    /**
     * @var string $path
     */
    private $path = "http://iot-platform.local/oauth/token";

    /**
     * Oauth constructor.
     * @param $user
     * @param $password
     * @param $clientId
     * @param $clientSecret
     * @throws RequestExceptions
     */
    function __construct($user, $password, $clientId, $clientSecret)
    {
        if (!empty($user) && !empty($password) && !empty($clientId) && !empty($clientSecret)) {
            $this->user = $user;
            $this->password = $password;
            $this->clientId = $clientId;
            $this->clientSecret = $clientSecret;
            if (Storage::exists($this->storagePath . md5($this->user))) {
                Storage::delete($this->storagePath . md5($this->user));
            }
        } else {
            throw new RequestExceptions(801, "Incorrect or empty parameters");
        }
    }

    /**
     * This function allows generating a token.
     *
     * @throws \AccentLabs\Trackingsdk\Exceptions\RequestExceptions
     */
    private function getTocken()
    {
        try {
            $http = new GuzzleHttp\Client;
            $response = $http->post($this->path, [
                'form_params' => [
                    'grant_type' => "password",
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'username' => $this->user,
                    'password' => $this->password,
                    'scope' => "api",
                ],
            ]);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                throw new RequestExceptions($e->getResponse()->getStatusCode(), $e->getResponse()->getReasonPhrase());
            } else {
                throw new RequestExceptions(800, "Unknown error");
            }
        }
        $responseOauth = json_decode((string)$response->getBody(), true);
        $responseOauth["expires_in"] = Carbon::now()->addSeconds($responseOauth["expires_in"])->format('Y-m-d H:i:s');
        Storage::delete($this->storagePath . md5($this->user));
        Storage::put($this->storagePath . md5($this->user), json_encode($responseOauth));
        $this->token = $responseOauth["access_token"];
        $this->tokenType = $responseOauth["token_type"];
    }

    /**
     * This function allows refresh a token.
     *
     * @param $refreshToken
     * @throws RequestExceptions
     */
    private function refreshToken($refreshToken)
    {
        $error = false;
        try {
            $http = new GuzzleHttp\Client;
            $response = $http->post($this->path, [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $refreshToken,
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                ],
            ]);
        } catch (RequestException $e) {
            $error = true;
        }
        if (!$error) {
            $responseOauth = json_decode((string)$response->getBody(), true);
            $responseOauth["expires_in"] = Carbon::now()->addSeconds($responseOauth["expires_in"])->format('Y-m-d H:i:s');
            Storage::delete($this->storagePath . md5($this->user));
            Storage::put($this->storagePath . md5($this->user), json_encode($responseOauth));
            $this->token = $responseOauth["access_token"];
            $this->tokenType = $responseOauth["token_type"];
        } else {
            $this->getTocken();
        }
    }


    /**
     * This function manages the user's token.
     *
     * @throws RequestExceptions
     */
    public function controlToken()
    {
        if (Storage::exists($this->storagePath . md5($this->user))) {
            $userInfo = Storage::get($this->storagePath . md5($this->user));
            $userInfo = json_decode($userInfo, true);
            $now = Carbon::now()->format('Y-m-d H:i:s');
            if ($userInfo["expires_in"] < $now) {
                $this->refreshToken($userInfo["refresh_token"]);
            } else {
                $this->token = $userInfo["access_token"];
                $this->tokenType = $userInfo["token_type"];
            }
        } else {
            $this->getTocken();
        }
    }

}