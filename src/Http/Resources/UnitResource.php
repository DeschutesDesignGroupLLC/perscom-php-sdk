<?php

namespace Perscom\Http\Resources;

use Perscom\Contracts\ResourceContract;
use Perscom\Data\FilterObject;
use Perscom\Data\ScopeObject;
use Perscom\Data\SortObject;
use Perscom\Http\Requests\Units\CreateUnitRequest;
use Perscom\Http\Requests\Units\DeleteUnitRequest;
use Perscom\Http\Requests\Units\GetUnitRequest;
use Perscom\Http\Requests\Units\GetUnitsRequest;
use Perscom\Http\Requests\Units\SearchUnitsRequest;
use Perscom\Http\Requests\Units\UpdateUnitRequest;
use Saloon\Contracts\Response;

class UnitResource extends Resource implements ResourceContract
{
    /**
     * @param  string|array<string>  $include
     * @param  int  $page
     * @param  int  $limit
     * @return Response
     */
    public function all(string|array $include = [], int $page = 1, int $limit = 20): Response
    {
        return $this->connector->send(new GetUnitsRequest($include, $page, $limit));
    }

    /**
     * @param  string|null  $value
     * @param  SortObject|array<SortObject>|null  $sort
     * @param  FilterObject|array<FilterObject>|null  $filter
     * @param  ScopeObject|array<ScopeObject>|null  $scope
     * @param  string|array<string>  $include
     * @param  int  $page
     * @param  int  $limit
     * @return Response
     */
    public function search(
        ?string $value = null,
        mixed $sort = null,
        mixed $filter = null,
        mixed $scope = null,
        string|array $include = [],
        int $page = 1,
        int $limit = 20,
    ): Response {
        return $this->connector->send(new SearchUnitsRequest($value, $sort, $filter, $scope, $include, $page, $limit));
    }

    /**
     * @param  int  $id
     * @param  string|array<string>  $include
     * @return Response
     */
    public function get(int $id, string|array $include = []): Response
    {
        return $this->connector->send(new GetUnitRequest($id, $include));
    }

    /**
     * @param  array<string, mixed>  $data
     * @return Response
     */
    public function create(array $data): Response
    {
        return $this->connector->send(new CreateUnitRequest($data));
    }

    /**
     * @param  int  $id
     * @param  array<string, mixed>  $data
     * @return Response
     */
    public function update(int $id, array $data): Response
    {
        return $this->connector->send(new UpdateUnitRequest($id, $data));
    }

    /**
     * @param  int  $id
     * @return Response
     */
    public function delete(int $id): Response
    {
        return $this->connector->send(new DeleteUnitRequest($id));
    }
}
