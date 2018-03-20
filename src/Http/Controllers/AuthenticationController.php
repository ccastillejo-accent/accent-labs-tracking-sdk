<?php
/**
 * Created by PhpStorm.
 * User: kilian
 * Date: 15/03/18
 * Time: 16:35
 */

namespace AccentLabs\TrackingSdk\Http\Controllers;


use AccentLabs\TrackingSdk\Api\ApiRequest;
use AccentLabs\TrackingSdk\Api\Client;
use AccentLabs\TrackingSdk\Api\Project;
use AccentLabs\TrackingSdk\Api\Tracker;
use AccentLabs\Trackingsdk\Exceptions\RequestExceptions;
use App\Http\Controllers\Controller;
use App\Models\TrackerInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Polyline;
use AccentLabs\TrackingSdk\Authentication\Oauth;


class AuthenticationController extends Controller
{


    public function kilian()
    {
        try {
            $apiRequest = new ApiRequest('kjaen@accent-systems.com', 'mmSC3n9d3!', '2', 'gmnn1nbEeC6AtvwEC1JuqJIkfya3yoXVJVEp66CR');
        } catch (RequestExceptions $e) {
            dump('entro al home');
            dump($e->getResponse());
        }

        try {
            $client = new Client($apiRequest);
            $clients = $client->list();

            $tracker = new Tracker($apiRequest);
            $trackers = $tracker->list();

            $project = new Project($apiRequest);

            $projects = $project->list('au');
        } catch (RequestExceptions $e) {
            dump('entro al home');
            dump($e->getResponse());
        }
        //$clients = $valor->getClientList();


        //$tracker = $valor->getTrackerList();
        //$json_a = json_decode((string)$valor->getBody(), true);
        dump('clients!');
        dump($clients);
        dump('tracker!');
        dump($trackers);
        dump('projects!');
        dump($projects);
    }
}
