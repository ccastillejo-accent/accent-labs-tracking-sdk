<?php
/**
 * Created by PhpStorm.
 * User: kilian
 * Date: 16/03/18
 * Time: 10:48
 */

namespace AccentLabs\TrackingSdk\Api;


use AccentLabs\TrackingSdk\Authentication\Oauth;
use AccentLabs\TrackingSdk\Exceptions\RequestExceptions;
use GuzzleHttp;
use GuzzleHttp\Exception\RequestException;

/**
 * Class ApiRequest
 * @package AccentLabs\TrackingSdk\Api
 */
class ApiRequest
{
    /**
     * @var Oauth $infoToken
     */
    private $infoToken;

    /**
     * @var string $path
     */
    private $path = "http://iot-platform.local/api/";

    /**
     * ApiRequest constructor.
     * @param string $user
     * @param string $password
     * @param int $clientId
     * @param string $clientSecret
     */
    function __construct($user, $password, $clientId, $clientSecret)
    {
        $this->infoToken = new Oauth($user, $password, $clientId, $clientSecret);
    }

    /**
     * This function allows make request to the api.
     *
     * @param string $typeRequest
     * @param string $class
     * @param string $type
     * @param array $params
     *
     * @return mixed|string
     * @throws RequestExceptions
     */
    public function makeRequest($typeRequest, $class, $type = null, $params = [])
    {
        $http = new GuzzleHttp\Client;
        $this->infoToken->controlToken();
        if (!empty($this->infoToken->tokenType) && !empty($this->infoToken->token)) {
            $typeRequest = strtolower($typeRequest);
            $type = ucfirst($type);
            /*switch ($typeRequest) {
                case 'get':
                    if (empty($type)) {
                        $type = 'List';
                    }
                    break;
                case 'post':
                    if (empty($type)) {
                        $type = 'Create';
                    }
                    break;
                case 'put':
                    if (empty($type)) {
                        $data['id'] = intval($type);
                        $type = 'Update';
                    }
                    break;
                case 'delete':
                    if (empty($type)) {
                        $type = 'Delete';
                    }
                    break;
            }

            $typeRequest = 'post';*/

            //$params = json_encode($params);
            try {
                $response = $http->$typeRequest($this->path . $class . '/' . $type, [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept-Language' => 'application/json',
                        'Authorization' => $this->infoToken->tokenType . ' ' . $this->infoToken->token],
                    'body' => json_encode($params)
                ]);
            } catch (RequestException $e) {
                if ($e->hasResponse()) {
                    throw new RequestExceptions($e->getResponse()->getStatusCode(), $e->getResponse()->getReasonPhrase());
                } else {
                    throw new RequestExceptions(800, "Unknown error");
                }
            }

            $responseOauth = json_decode((string)$response->getBody());
            return $responseOauth;
        } else {
            throw new RequestExceptions(802, "Empty token");
        }
    }


}