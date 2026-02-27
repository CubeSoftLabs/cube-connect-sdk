<?php

namespace CubeConnect\Facades;

use CubeConnect\Contracts\Messaging;
use CubeConnect\DTOs\MessageResponse;
use Illuminate\Support\Facades\Facade;

/**
 * @method static MessageResponse sendText(string $phone, string $body)
 * @method static MessageResponse sendTemplate(string $phone, string $name, array $params = [])
 * @method static array health()
 *
 * @see \CubeConnect\CubeConnect
 */
class CubeConnect extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return Messaging::class;
    }
}
