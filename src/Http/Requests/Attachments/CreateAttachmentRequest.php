<?php

declare(strict_types=1);

namespace Perscom\Http\Requests\Attachments;

use Saloon\Contracts\Body\HasBody;
use Saloon\Data\MultipartValue;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasMultipartBody;

class CreateAttachmentRequest extends Request implements HasBody
{
    use HasMultipartBody;

    protected Method $method = Method::POST;

    /**
     * @param  array<string, mixed>  $data
     */
    public function __construct(public array $data)
    {
        //
    }

    public function resolveEndpoint(): string
    {
        return 'attachments';
    }

    /**
     * @return MultipartValue[]
     */
    protected function defaultBody(): array
    {
        return collect($this->data)->map(fn ($value, $key) => new MultipartValue(
            name: $key,
            value: $value
        ))->toArray();
    }
}
