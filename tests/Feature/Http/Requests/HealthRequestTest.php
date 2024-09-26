
<?php

use Perscom\Exceptions\AuthenticationException;
use Perscom\Exceptions\NotFoundHttpException;
use Perscom\Exceptions\TenantCouldNotBeIdentifiedException;
use Perscom\Http\Requests\HealthRequest;
use Perscom\Http\Requests\Users\AssignmentRecords\GetUserAssignmentRecordRequest;
use Perscom\Http\Requests\Users\AssignmentRecords\GetUserAssignmentRecordsRequest;
use Perscom\Http\Requests\Users\GetUserRequest;
use Perscom\Http\Requests\Users\GetUsersRequest;
use Perscom\PerscomConnection;
use Saloon\Exceptions\Request\Statuses\UnauthorizedException;
use Saloon\Config;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Repositories\ArrayStore;

beforeEach(function () {
    Config::preventStrayRequests();

    $this->mockClient = new MockClient([
        HealthRequest::class => MockResponse::make(status: 200),
    ]);

    $this->connector = new PerscomConnection('foo', 'bar');
    $this->connector->withMockClient($this->mockClient);
});

test('it can get the API health status', function () {
    $response = $this->connector->health()->get();

    expect($response->status())->toEqual(200)
       ->and($response)->toBeInstanceOf(Response::class);

    $this->mockClient->assertSent(HealthRequest::class);
});