<?php
/**
 * Created by PhpStorm.
 * User: kilian
 * Date: 16/03/18
 * Time: 12:22
 */

namespace AccentLabs\TrackingSdk\Api;

use AccentLabs\TrackingSdk\Exceptions\RequestExceptions;

/**
 * Class Client
 * @package AccentLabs\TrackingSdk\Api
 */
class Client
{
    /**
     * @var ApiRequest
     */
    private $apiRequest;

    /**
     * Client constructor.
     * @param ApiRequest $apiRequest
     */
    function __construct(ApiRequest $apiRequest)
    {
        $this->apiRequest = $apiRequest;
    }

    /**
     * @return mixed|string
     * @throws RequestExceptions
     */
    public function list()
    {
        return $this->apiRequest->makeRequest('post', 'client', 'List');
    }
}