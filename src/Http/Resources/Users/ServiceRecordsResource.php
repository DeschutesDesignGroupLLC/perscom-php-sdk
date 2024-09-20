<?php

declare(strict_types=1);

namespace Perscom\Http\Resources\Users;

use Perscom\Contracts\ResourceContract;
use Perscom\Http\Requests\Users\ServiceRecords\CreateUserServiceRecordRequest;
use Perscom\Http\Requests\Users\ServiceRecords\DeleteUserServiceRecordRequest;
use Perscom\Http\Requests\Users\ServiceRecords\GetUserServiceRecordRequest;
use Perscom\Http\Requests\Users\ServiceRecords\GetUserServiceRecordsRequest;
use Perscom\Http\Requests\Users\ServiceRecords\UpdateUserServiceRecordRequest;
use Perscom\Http\Resources\Resource;
use Saloon\Contracts\Connector;
use Saloon\Contracts\Response;

class ServiceRecordsResource extends Resource implements ResourceContract
{
    public function __construct(protected Connector $connector, protected int $relationId)
    {
        parent::__construct($connector);
    }

    /**
     * @param  string|array<string>  $include
     */
    public function all(string|array $include = [], int $page = 1, int $limit = 20): Response
    {
        return $this->connector->send(new GetUserServiceRecordsRequest($this->relationId, $include, $page, $limit));
    }

    /**
     * @param  string|array<string>  $include
     */
    public function get(int $id, string|array $include = []): Response
    {
        return $this->connector->send(new GetUserServiceRecordRequest($this->relationId, $id, $include));
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Response
    {
        return $this->connector->send(new CreateUserServiceRecordRequest($this->relationId, $data));
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(int $id, array $data): Response
    {
        return $this->connector->send(new UpdateUserServiceRecordRequest($this->relationId, $id, $data));
    }

    public function delete(int $id): Response
    {
        return $this->connector->send(new DeleteUserServiceRecordRequest($this->relationId, $id));
    }
}
