<?php

namespace Novu\Laravel\Exceptions;

use InvalidArgumentException;

final class ApiKeyIsMissing extends InvalidArgumentException
{
    /**
     * Create a new APIKeyIsMissing expection instance.
     */
    public static function create(): self
    {
        return new self(
            "The Novu API key is missing. Please set the NOVU_API_KEY variable in your application's .env file"
        );
    }
}