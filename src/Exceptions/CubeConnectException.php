<?php

namespace CubeConnect\Exceptions;

use Exception;

class CubeConnectException extends Exception
{
    /**
     * The HTTP status code from the API response.
     *
     * @var int
     */
    public int $statusCode;

    /**
     * The error code from the API response (e.g. "INVALID_API_KEY").
     *
     * @var string
     */
    public string $errorCode;

    /**
     * Create a new CubeConnect exception instance.
     *
     * @param  string  $message
     * @param  int  $statusCode
     * @param  string  $errorCode
     * @param  \Throwable|null  $previous
     * @return void
     */
    public function __construct(string $message = '', int $statusCode = 0, string $errorCode = '', ?\Throwable $previous = null)
    {
        $this->statusCode = $statusCode;
        $this->errorCode = $errorCode;

        parent::__construct($message, $statusCode, $previous);
    }

    /**
     * Create a new exception for a server error response.
     *
     * @param  int  $statusCode
     * @param  string  $errorCode
     * @param  string  $message
     * @return static
     */
    public static function serverError(int $statusCode, string $errorCode = '', string $message = ''): static
    {
        return new static(
            $message ?: "CubeConnect API returned an unexpected response [{$statusCode}].",
            $statusCode,
            $errorCode ?: 'SERVER_ERROR',
        );
    }

    /**
     * Create a new exception for a connection failure.
     *
     * @param  \Throwable  $previous
     * @return static
     */
    public static function connectionFailed(\Throwable $previous): static
    {
        return new static(
            'Unable to connect to CubeConnect API.',
            0,
            'CONNECTION_FAILED',
            $previous,
        );
    }
}
