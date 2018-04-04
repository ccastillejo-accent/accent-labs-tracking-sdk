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
 * Class Beacon
 * @package AccentLabs\TrackingSdk\Api
 */
class Beacon
{
    /**
     * @var ApiRequest
     */
    private $apiRequest;

    /**
     * Beacon constructor.
     * @param ApiRequest $apiRequest
     */
    function __construct(ApiRequest $apiRequest)
    {
        $this->apiRequest = $apiRequest;
    }

    /**
     * This command allows you to get list of beacons
     *
     * @param string name
     * @param int client_id
     *
     * @return mixed|string
     *
     * @throws RequestExceptions
     */
    public function list($name = null, $clientId = null)
    {
        $params = [];

        if (!empty($name)) {
            $params['name'] = $name;
        }
        if (!empty($clientId)) {
            $params['client_id'] = $clientId;
        }
        return $this->controlRequest('post', 'List', $params);

    }

    /**
     * This command allows you create a beacon
     *
     * @param string name required
     * @param string mac required
     * @param string uuid required
     * @param string major required
     * @param string minor required
     * @param float lat required
     * @param float lng required
     *
     * @return mixed|string
     *
     * @throws RequestExceptions
     */
    public function create($name, $mac, $uuid, $major, $minor, $lat, $lng)
    {
        $params = ['name' => $name, 'mac' => $mac, 'uuid' => $uuid, 'major' => $major, 'minor' => $minor, 'lat' => $lat, 'lng' => $lng];
        return $this->controlRequest('post', 'Create', $params);
    }

    /**
     * This command allows you update a beacon
     *
     * @param $id
     * @param string $name
     * @param string $mac
     * @param string $uuid
     * @param string $major
     * @param string $minor
     * @param string $lat
     * @param string $lng
     *
     * @return mixed|string
     *
     * @throws RequestExceptions
     */
    public function update($id, $name = null, $mac = null, $uuid = null, $major = null, $minor = null, $lat = null, $lng = null)
    {
        $params = ['id' => $id];
        if (!empty($name)) {
            $params['name'] = $name;
        }
        if (!empty($mac)) {
            $params['mac'] = $mac;
        }
        if (!empty($uuid)) {
            $params['uuid'] = $uuid;
        }
        if (!empty($major)) {
            $params['major'] = $major;
        }
        if (!empty($minor)) {
            $params['minor'] = $minor;
        }
        if (!empty($lat) && is_numeric($lat)) {
            $params['lat'] = $lat;
        }
        if (!empty($lng) && is_numeric($lng)) {
            $params['lng'] = $lng;
        }

        return $this->controlRequest('post', 'Update', $params);
    }

    /**
     * This command allows you delete a beacon
     *
     * @param int $id
     *
     * @return mixed|string
     *
     * @throws \AccentLabs\Trackingsdk\Exceptions\RequestExceptions
     */
    public function delete($id)
    {
        $params = ['id' => $id];
        return $this->controlRequest('post', 'Delete', $params);
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
        $response = $this->apiRequest->makeRequest($typeRequest, 'beacon', $type, $params);

        if (count($response) > 0 && $response->status == 'ok') {
            return $response;
        } else {
            throw new RequestExceptions($response->error->code, $response->error->msg);
        }
    }
}