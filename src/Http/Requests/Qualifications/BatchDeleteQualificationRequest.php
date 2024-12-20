<?php

declare(strict_types=1);

namespace Perscom\Http\Requests\Qualifications;

use Perscom\Http\Requests\AbstractBatchDeleteRequest;

class BatchDeleteQualificationRequest extends AbstractBatchDeleteRequest
{
    protected function getResource(): string
    {
        return 'qualifications';
    }
}
