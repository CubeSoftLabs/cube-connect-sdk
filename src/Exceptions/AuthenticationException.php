<?php

namespace CubeConnect\Exceptions;

class AuthenticationException extends CubeConnectException
{
    /**
     * Create a new authentication exception for an invalid API key.
     *
     * @param  string  $errorCode
     * @param  string  $message
     * @return static
     */
    public static function invalidKey(string $errorCode = '', string $message = ''): static
    {
        return new static(
            $message ?: 'The provided API key is invalid.',
            401,
            $errorCode ?: 'INVALID_API_KEY',
        );
    }

    /**
     * Create a new authentication exception for a missing API key.
     *
     * @return static
     */
    public static function missingKey(): static
    {
        return new static(
            'An API key is required. Set CUBECONNECT_API_KEY in your .env file.',
            401,
            'AUTHENTICATION_REQUIRED',
        );
    }

    /**
     * Create a new authentication exception for insufficient permissions.
     *
     * @param  string  $errorCode
     * @param  string  $message
     * @return static
     */
    public static function forbidden(string $errorCode = '', string $message = ''): static
    {
        return new static(
            $message ?: 'The API key does not have access to this resource.',
            403,
            $errorCode ?: 'FORBIDDEN',
        );
    }
}
