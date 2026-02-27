<?php

namespace CubeConnect\Exceptions;

class RateLimitException extends CubeConnectException
{
    /**
     * Create a new rate limit exception.
     *
     * @param  string  $errorCode  The API error code (RATE_LIMIT_EXCEEDED, PLAN_LIMIT_REACHED, SUBSCRIPTION_EXPIRED)
     * @param  string  $message
     * @return static
     */
    public static function exceeded(string $errorCode = '', string $message = ''): static
    {
        return new static(
            $message ?: 'Rate limit exceeded for your current plan.',
            429,
            $errorCode ?: 'RATE_LIMIT_EXCEEDED',
        );
    }
}
