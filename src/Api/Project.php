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
 * Class Project
 * @package AccentLabs\TrackingSdk\Api
 */
class Project
{
    /**
     * @var ApiRequest
     */
    private $apiRequest;

    /**
     * Project constructor.
     * @param ApiRequest $apiRequest
     */
    function __construct(ApiRequest $apiRequest)
    {
        $this->apiRequest = $apiRequest;
    }

    /**
     * This function allows you to get list of projects
     *
     * @param int $clientId
     * @param string $name
     *
     * @return mixed|string
     * @throws \AccentLabs\Trackingsdk\Exceptions\RequestExceptions
     */
    public function list($clientId, $name = null)
    {
        $params = ['client_id' => $clientId];
        if ($name != '') {
            $params['name'] = $name;
        }
        $response = $this->apiRequest->makeRequest('post', 'project', 'List', $params);

        dump($response);
        die;
        if (count($response) > 0 && $response->status == 'ok') {
            return $response;
        } else {
            throw new RequestExceptions(803, "Request error");
        }
    }

    /**
     * This command allows you create a project
     *
     * @param  int $clientId
     * @param string $name
     *
     * @return mixed|string
     * @throws \AccentLabs\Trackingsdk\Exceptions\RequestExceptions
     */
    public function create($clientId, $name)
    {
        $params = ['client_id' => $clientId, 'name' => $name];
        return $this->apiRequest->makeRequest('post', 'project', 'Create', $params);
    }

    /**
     * This command allows you update a project
     *
     * @param int $id
     * @param string $name
     *
     * @return mixed|string
     *
     * @throws \AccentLabs\Trackingsdk\Exceptions\RequestExceptions
     */
    public function update($id, $name)
    {
        $params = ['id' => $id, 'name' => $name];
        return $this->apiRequest->makeRequest('post', 'project', 'Update', $params);
    }


    /**
     * This command allows you delete a project
     *
     * @param int $id
     *
     * @return mixed|string
     * @throws \AccentLabs\Trackingsdk\Exceptions\RequestExceptions
     */
    public function delete($id)
    {
        $params = ['id' => $id];
        return $this->apiRequest->makeRequest('post', 'project', 'Delete', $params);
    }
}