<?php

namespace CubeConnect\Contracts;

use CubeConnect\DTOs\MessageResponse;

interface Messaging
{
    /**
     * Send a text message to a WhatsApp number.
     *
     * @param  string  $phone
     * @param  string  $body
     * @return \CubeConnect\DTOs\MessageResponse
     *
     * @throws \CubeConnect\Exceptions\AuthenticationException
     * @throws \CubeConnect\Exceptions\ValidationException
     * @throws \CubeConnect\Exceptions\RateLimitException
     * @throws \CubeConnect\Exceptions\CubeConnectException
     */
    public function sendText(string $phone, string $body): MessageResponse;

    /**
     * Send a pre-approved template message.
     *
     * @param  string  $phone
     * @param  string  $name
     * @param  array<int, string>  $params
     * @param  string  $languageCode
     * @return \CubeConnect\DTOs\MessageResponse
     *
     * @throws \CubeConnect\Exceptions\AuthenticationException
     * @throws \CubeConnect\Exceptions\ValidationException
     * @throws \CubeConnect\Exceptions\RateLimitException
     * @throws \CubeConnect\Exceptions\CubeConnectException
     */
    public function sendTemplate(string $phone, string $name, array $params = [], string $languageCode = 'en_US'): MessageResponse;

    /**
     * Check the platform health status.
     *
     * @return array{status: string, checks: array{app: bool, database: bool, cache: bool}, timestamp: string}
     */
    public function health(): array;
}
