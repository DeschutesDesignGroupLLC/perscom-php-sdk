<?php

declare(strict_types=1);

namespace Perscom\Http\Requests;

use Illuminate\Support\Arr;
use Perscom\Data\ResourceObject;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

abstract class AbstractRelationalSyncRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param  int  $relationId
     * @param  ResourceObject|array<ResourceObject>  $resources
     * @param  string|array  $include
     * @param  bool  $allowDetaching
     */
    public function __construct(
        public int $relationId,
        public ResourceObject|array $resources,
        public string|array $include = [],
        public bool $allowDetaching = true
    ) {
        $this->resources = Arr::wrap($this->resources);
        $this->include = Arr::wrap($this->include);
    }

    /**
     * @return string
     */
    public function resolveEndpoint(): string
    {
        return "{$this->getResource($this->relationId)}/sync";
    }

    /**
     * @param  int  $relationId
     * @return string
     */
    abstract protected function getResource(int $relationId): string;

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        $query = [];

        if (filled($this->include)) {
            $query['include'] = implode(',', $this->include);
        }

        return $query;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        $resources = array_map(
            static fn (ResourceObject $resource) => $resource->toArray(),
            $this->resources
        );

        return [
            'resources' => array_replace(...$resources),
            'detaching' => $this->allowDetaching,
        ];
    }
}
