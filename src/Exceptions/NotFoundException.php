<?php

namespace CubeConnect\Exceptions;

class NotFoundException extends CubeConnectException
{
    /**
     * Create a new not found exception.
     *
     * @param  string  $errorCode  The API error code (NOT_FOUND, TEMPLATE_NOT_FOUND)
     * @param  string  $message
     * @return static
     */
    public static function resource(string $errorCode = '', string $message = ''): static
    {
        return new static(
            $message ?: 'The requested resource was not found.',
            404,
            $errorCode ?: 'NOT_FOUND',
        );
    }
}
