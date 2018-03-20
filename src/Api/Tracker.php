<?php
/**
 * Created by PhpStorm.
 * User: kilian
 * Date: 16/03/18
 * Time: 12:22
 */

namespace AccentLabs\TrackingSdk\Api;


class Tracker
{
    private $apiRequest;

    function __construct(ApiRequest $apiRequest)
    {
        $this->apiRequest = $apiRequest;
    }

    public function list($name = null, $projectId = null, $trackerTypeId = null, $clientId = null)
    {
        $params = [];

        if ($name != '') {
            $params['name'] = $name;
        }
        if ($projectId != '') {
            $params['project_id'] = $projectId;
        }
        if ($trackerTypeId != '') {
            $params['tracker_type_id'] = $trackerTypeId;
        }
        if ($clientId != '') {
            $params['client_id'] = $clientId;
        }

        return $this->apiRequest->makeRequest('post', 'tracker', 'List', $params);
    }
}