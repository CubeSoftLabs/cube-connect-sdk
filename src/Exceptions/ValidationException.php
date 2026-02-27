<?php

namespace CubeConnect\Exceptions;

class ValidationException extends CubeConnectException
{
    /**
     * The validation errors from the API response.
     *
     * @var array<string, array<int, string>>
     */
    public array $errors;

    /**
     * Create a new validation exception instance.
     *
     * @param  string  $message
     * @param  string  $errorCode
     * @param  array<string, array<int, string>>  $errors
     * @return void
     */
    public function __construct(string $message = '', string $errorCode = '', array $errors = [])
    {
        $this->errors = $errors;

        parent::__construct($message, 422, $errorCode ?: 'VALIDATION_ERROR');
    }

    /**
     * Create a new exception from an API validation error response.
     *
     * @param  string  $errorCode
     * @param  string  $message
     * @param  array<string, array<int, string>>  $errors
     * @return static
     */
    public static function withErrors(string $errorCode, string $message, array $errors = []): static
    {
        return new static($message, $errorCode, $errors);
    }
}
