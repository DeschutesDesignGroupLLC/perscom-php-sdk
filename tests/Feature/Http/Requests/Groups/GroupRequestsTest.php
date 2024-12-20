<?php

declare(strict_types=1);

use Perscom\Data\ResourceObject;
use Perscom\Http\Requests\Groups\BatchCreateGroupRequest;
use Perscom\Http\Requests\Groups\BatchDeleteGroupRequest;
use Perscom\Http\Requests\Groups\BatchUpdateGroupRequest;
use Perscom\Http\Requests\Groups\CreateGroupRequest;
use Perscom\Http\Requests\Groups\DeleteGroupRequest;
use Perscom\Http\Requests\Groups\GetGroupRequest;
use Perscom\Http\Requests\Groups\GetGroupsRequest;
use Perscom\Http\Requests\Groups\SearchGroupsRequest;
use Perscom\Http\Requests\Groups\UpdateGroupRequest;
use Perscom\PerscomConnection;
use Saloon\Config;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Http\Response;

beforeEach(function () {
    Config::preventStrayRequests();

    $this->mockClient = new MockClient([
        GetGroupsRequest::class => MockResponse::make([
            'name' => 'foo',
        ]),
        SearchGroupsRequest::class => MockResponse::make([
            'data' => [
                [
                    'id' => 1,
                    'name' => 'foo',
                ],
            ],
        ]),
        GetGroupRequest::class => MockResponse::make([
            'id' => 1,
            'name' => 'foo',
        ]),
        CreateGroupRequest::class => MockResponse::make([
            'id' => 1,
            'name' => 'foo',
        ]),
        UpdateGroupRequest::class => MockResponse::make([
            'id' => 1,
            'name' => 'foo',
        ]),
        DeleteGroupRequest::class => MockResponse::make([], 201),
        BatchCreateGroupRequest::class => MockResponse::make([
            'data' => [
                'id' => 1,
                'name' => 'foo',
            ],
        ]),
        BatchUpdateGroupRequest::class => MockResponse::make([
            'data' => [
                'id' => 1,
                'name' => 'foo',
            ],
        ]),
        BatchDeleteGroupRequest::class => MockResponse::make([
            'data' => [
                'id' => 1,
                'name' => 'foo',
            ],
        ]),
    ]);

    $this->connector = new PerscomConnection('foo', 'bar');
    $this->connector->withMockClient($this->mockClient);
});

test('it can get all groups', function () {
    $response = $this->connector->groups()->all();

    $data = $response->json();

    expect($response->status())->toEqual(200)
        ->and($response)->toBeInstanceOf(Response::class)
        ->and($data)->toEqual([
            'name' => 'foo',
        ]);

    $this->mockClient->assertSent(GetGroupsRequest::class);
});

test('it can search groups', function () {
    $response = $this->connector->groups()->search('foo');

    $data = $response->json();

    expect($response->status())->toEqual(200)
        ->and($response)->toBeInstanceOf(Response::class)
        ->and($data)->toEqual([
            'data' => [
                [
                    'id' => 1,
                    'name' => 'foo',
                ],
            ],
        ]);

    $this->mockClient->assertSent(SearchGroupsRequest::class);
});

test('it can get a group', function () {
    $response = $this->connector->groups()->get(1);

    $data = $response->json();

    expect($response->status())->toEqual(200)
        ->and($response)->toBeInstanceOf(Response::class)
        ->and($data)->toEqual([
            'name' => 'foo',
            'id' => 1,
        ]);

    $this->mockClient->assertSent(function (Request $request) {
        return $request instanceof GetGroupRequest
            && $request->id === 1;
    });
});

test('it can create a group', function () {
    $response = $this->connector->groups()->create([
        'foo' => 'bar',
    ]);

    $data = $response->json();

    expect($response->status())->toEqual(200)
        ->and($response)->toBeInstanceOf(Response::class)
        ->and($data)->toEqual([
            'name' => 'foo',
            'id' => 1,
        ]);

    $this->mockClient->assertSent(function (Request $request) {
        return $request instanceof CreateGroupRequest
            && $request->data['foo'] === 'bar';
    });
});

test('it can update a group', function () {
    $response = $this->connector->groups()->update(1, [
        'foo' => 'bar',
    ]);

    $data = $response->json();

    expect($response->status())->toEqual(200)
        ->and($response)->toBeInstanceOf(Response::class)
        ->and($data)->toEqual([
            'name' => 'foo',
            'id' => 1,
        ]);

    $this->mockClient->assertSent(function (Request $request) {
        return $request instanceof UpdateGroupRequest
            && $request->id === 1
            && $request->data['foo'] === 'bar';
    });
});

test('it can delete a group', function () {
    $response = $this->connector->groups()->delete(1);

    $data = $response->json();

    expect($response->status())->toEqual(201)
        ->and($response)->toBeInstanceOf(Response::class)
        ->and($data)->toEqual([]);

    $this->mockClient->assertSent(function (Request $request) {
        return $request instanceof DeleteGroupRequest
            && $request->id === 1;
    });
});

test('it can batch create groups', function () {
    $response = $this->connector->groups()->batchCreate(new ResourceObject(data: [
        'foo' => 'bar',
    ]));

    $data = $response->json();

    expect($response->status())->toEqual(200)
        ->and($response)->toBeInstanceOf(Response::class)
        ->and($data)->toEqual([
            'data' => [
                'id' => 1,
                'name' => 'foo',
            ],
        ]);

    $this->mockClient->assertSent(function (Request $request) {
        return $request instanceof BatchCreateGroupRequest;
    });
});

test('it can batch update groups', function () {
    $response = $this->connector->groups()->batchUpdate(new ResourceObject(1, [
        'foo' => 'bar',
    ]));

    $data = $response->json();

    expect($response->status())->toEqual(200)
        ->and($response)->toBeInstanceOf(Response::class)
        ->and($data)->toEqual([
            'data' => [
                'id' => 1,
                'name' => 'foo',
            ],
        ]);

    $this->mockClient->assertSent(function (Request $request) {
        return $request instanceof BatchUpdateGroupRequest;
    });
});

test('it can batch delete groups', function () {
    $response = $this->connector->groups()->batchDelete(new ResourceObject(1));

    $data = $response->json();

    expect($response->status())->toEqual(200)
        ->and($response)->toBeInstanceOf(Response::class)
        ->and($data)->toEqual([
            'data' => [
                'id' => 1,
                'name' => 'foo',
            ],
        ]);

    $this->mockClient->assertSent(function (Request $request) {
        return $request instanceof BatchDeleteGroupRequest;
    });
});
