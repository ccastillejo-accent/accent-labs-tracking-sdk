Inmolecular Cloud SDK
==========

**This library contains PHP implementations of the Inmolecular Cloud operations.**

### Usage:

All models have **CRUD** methods, `create()` `list()` `update()` and `delete()` methods which accept different parameters depending on the model.

Beacon:

```php
$apiRequest = new AccentLabs\TrackingSdk\Api\ApiRequest($user, $pass, $clientID, $clientSecret);

$becaonApi = new AccentLabs\TrackingSdk\Api\Beacon($apiRequest);

//List all your beacons
$beacons = $beaconApi->list();

//Create beacon
$beacon = $beaconApi->create($name, $mac, $uuid, $major, $minor, $lat, $lng);

//Update beacon
$beacon = $beaconApi->update($beacon->id, $newName, ...);

//Delete beacon
$beaconApi->delete($beacon->id);
```

Project:

```php
$apiRequest = new AccentLabs\TrackingSdk\Api\ApiRequest($user, $pass, $clientID, $clientSecret);

$projectApi = new AccentLabs\TrackingSdk\Api\Project($apiRequest);

//List all your projects
$projects = $projectApi->list($clientId);

//Create project
$project = $projectApi->create($name);

//Update project
$project = $projectApi->update($project->id, $newName);

//Delete project
$projectApi->delete($beacon->id);
```
