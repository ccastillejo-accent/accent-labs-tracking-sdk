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
 * Class Tracker
 * @package AccentLabs\TrackingSdk\Api
 */
class Tracker
{
    /**
     * @var ApiRequest
     */
    private $apiRequest;

    /**
     * Tracker constructor.
     * @param ApiRequest $apiRequest
     */
    function __construct(ApiRequest $apiRequest)
    {
        $this->apiRequest = $apiRequest;
    }

    /**
     * This command allows you to get list of trackers
     *
     * @param string name
     * @param int project_id
     * @param int tracker_type_id
     * @param int client_id
     *
     * @return mixed|string
     *
     * @throws RequestExceptions
     */
    public function list($name = null, $projectId = null, $trackerTypeId = null, $clientId = null)
    {
        $params = [];

        if (!empty($name)) {
            $params['name'] = $name;
        }
        if (!empty($projectId)) {
            $params['project_id'] = $projectId;
        }
        if (!empty($trackerTypeId)) {
            $params['tracker_type_id'] = $trackerTypeId;
        }
        if (!empty($clientId)) {
            $params['client_id'] = $clientId;
        }

        return $this->controlRequest('post', 'List', $params);
    }

    /**
     * @param $typeRequest
     * @param $type
     * @param $params
     *
     * @return mixed|string
     *
     * @throws RequestExceptions
     */
    private function controlRequest($typeRequest, $type, $params)
    {
        $response = $this->apiRequest->makeRequest($typeRequest, 'tracker', $type, $params);

        if (count($response) > 0 && $response->status == 'ok') {
            return $response;
        } else {
            throw new RequestExceptions($response->error->code, $response->error->msg);
        }
    }
}