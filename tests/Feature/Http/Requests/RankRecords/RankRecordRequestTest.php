<?php

use Perscom\Http\Requests\RankRecords\CreateRankRecordRequest;
use Perscom\Http\Requests\RankRecords\DeleteRankRecordRequest;
use Perscom\Http\Requests\RankRecords\GetRankRecordRequest;
use Perscom\Http\Requests\RankRecords\GetRankRecordsRequest;
use Perscom\Http\Requests\RankRecords\UpdateRankRecordRequest;
use Perscom\PerscomConnection;
use Saloon\Http\Request;
use Saloon\Config;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Response;

beforeEach(function () {
    Config::preventStrayRequests();

    $this->mockClient = new MockClient([
        GetRankRecordsRequest::class => MockResponse::make([
            'name' => 'foo',
        ], 200),
        GetRankRecordRequest::class => MockResponse::make([
            'id' => 1,
            'name' => 'foo',
        ], 200),
        CreateRankRecordRequest::class => MockResponse::make([
            'id' => 1,
            'name' => 'foo',
        ], 200),
        UpdateRankRecordRequest::class => MockResponse::make([
            'id' => 1,
            'name' => 'foo',
        ], 200),
        DeleteRankRecordRequest::class => MockResponse::make([], 201),
    ]);

    $this->connector = new PerscomConnection('foo', 'bar');
    $this->connector->withMockClient($this->mockClient);
});

test('it can get all rank records', function () {
    $response = $this->connector->rankRecords()->all();

    $data = $response->json();

    expect($response->status())->toEqual(200)
        ->and($response)->toBeInstanceOf(Response::class)
        ->and($data)->toEqual([
            'name' => 'foo',
        ]);

    $this->mockClient->assertSent(GetRankRecordsRequest::class);
});

test('it can get a rank record', function () {
    $response = $this->connector->rankRecords()->get(1);

    $data = $response->json();

    expect($response->status())->toEqual(200)
        ->and($response)->toBeInstanceOf(Response::class)
        ->and($data)->toEqual([
            'name' => 'foo',
            'id' => 1,
        ]);

    $this->mockClient->assertSent(function (Request $request) {
        return $request instanceof GetRankRecordRequest
            && $request->id === 1;
    });
});

test('it can create a rank record', function () {
    $response = $this->connector->rankRecords()->create([
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
        return $request instanceof CreateRankRecordRequest
            && $request->data['foo'] === 'bar';
    });
});

test('it can update a rank record', function () {
    $response = $this->connector->rankRecords()->update(1, [
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
        return $request instanceof UpdateRankRecordRequest
            && $request->id === 1
            && $request->data['foo'] === 'bar';
    });
});

test('it can delete a rank record', function () {
    $response = $this->connector->rankRecords()->delete(1);

    $data = $response->json();

    expect($response->status())->toEqual(201)
        ->and($response)->toBeInstanceOf(Response::class)
        ->and($data)->toEqual([]);

    $this->mockClient->assertSent(function (Request $request) {
        return $request instanceof DeleteRankRecordRequest
            && $request->id === 1;
    });
});