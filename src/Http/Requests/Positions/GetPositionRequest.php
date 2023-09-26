<?php

namespace Perscom\Http\Requests\Positions;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetPositionRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param int $id
     */
    public function __construct(public int $id)
    {
        //
    }

    /**
     * @return string
     */
    public function resolveEndpoint(): string
    {
        return "positions/{$this->id}";
    }
}