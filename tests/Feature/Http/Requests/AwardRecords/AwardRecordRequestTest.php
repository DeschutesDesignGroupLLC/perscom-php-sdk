<?php

use Perscom\Http\Requests\AwardRecords\CreateAwardRecordRequest;
use Perscom\Http\Requests\AwardRecords\DeleteAwardRecordRequest;
use Perscom\Http\Requests\AwardRecords\GetAwardRecordRequest;
use Perscom\Http\Requests\AwardRecords\GetAwardRecordsRequest;
use Perscom\Http\Requests\AwardRecords\UpdateAwardRecordRequest;
use Perscom\PerscomConnection;
use Saloon\Http\Request;
use Saloon\Config;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Response;

beforeEach(function () {
    Config::preventStrayRequests();

    $this->mockClient = new MockClient([
        GetAwardRecordsRequest::class => MockResponse::make([
            'name' => 'foo',
        ], 200),
        GetAwardRecordRequest::class => MockResponse::make([
            'id' => 1,
            'name' => 'foo',
        ], 200),
        CreateAwardRecordRequest::class => MockResponse::make([
            'id' => 1,
            'name' => 'foo',
        ], 200),
        UpdateAwardRecordRequest::class => MockResponse::make([
            'id' => 1,
            'name' => 'foo',
        ], 200),
        DeleteAwardRecordRequest::class => MockResponse::make([], 201),
    ]);

    $this->connector = new PerscomConnection('foo', 'bar');
    $this->connector->withMockClient($this->mockClient);
});

test('it can get all award records', function () {
    $response = $this->connector->awardRecords()->all();

    $data = $response->json();

    expect($response->status())->toEqual(200)
        ->and($response)->toBeInstanceOf(Response::class)
        ->and($data)->toEqual([
            'name' => 'foo',
        ]);

    $this->mockClient->assertSent(GetAwardRecordsRequest::class);
});

test('it can get an award record', function () {
    $response = $this->connector->awardRecords()->get(1);

    $data = $response->json();

    expect($response->status())->toEqual(200)
        ->and($response)->toBeInstanceOf(Response::class)
        ->and($data)->toEqual([
            'name' => 'foo',
            'id' => 1,
        ]);

    $this->mockClient->assertSent(function (Request $request) {
        return $request instanceof GetAwardRecordRequest
            && $request->id === 1;
    });
});

test('it can create an award record', function () {
    $response = $this->connector->awardRecords()->create([
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
        return $request instanceof CreateAwardRecordRequest
            && $request->data['foo'] === 'bar';
    });
});

test('it can update an award record', function () {
    $response = $this->connector->awardRecords()->update(1, [
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
        return $request instanceof UpdateAwardRecordRequest
            && $request->id === 1
            && $request->data['foo'] === 'bar';
    });
});

test('it can delete an award record', function () {
    $response = $this->connector->awardRecords()->delete(1);

    $data = $response->json();

    expect($response->status())->toEqual(201)
        ->and($response)->toBeInstanceOf(Response::class)
        ->and($data)->toEqual([]);

    $this->mockClient->assertSent(function (Request $request) {
        return $request instanceof DeleteAwardRecordRequest
            && $request->id === 1;
    });
});