<?php

namespace Perscom\Http\Requests\Qualifications;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateQualificationRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param array<string, mixed>  $data
     */
    public function __construct(public array $data)
    {
        //
    }

    /**
     * @return string
     */
    public function resolveEndpoint(): string
    {
        return 'qualifications';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return $this->data;
    }
}