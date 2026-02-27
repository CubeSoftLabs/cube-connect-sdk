# CubeConnect for Laravel

<p>
<a href="https://packagist.org/packages/cubeconnect/laravel"><img src="https://img.shields.io/packagist/v/cubeconnect/laravel.svg" alt="Latest Version"></a>
<a href="https://packagist.org/packages/cubeconnect/laravel"><img src="https://img.shields.io/packagist/l/cubeconnect/laravel.svg" alt="License"></a>
<a href="https://packagist.org/packages/cubeconnect/laravel"><img src="https://img.shields.io/packagist/php-v/cubeconnect/laravel.svg" alt="PHP Version"></a>
</p>

Official Laravel SDK for the [CubeConnect](https://cubeconnect.io) WhatsApp Business Platform.

## Installation

Install the package via Composer:

```bash
composer require cubeconnect/laravel
```

The package auto-discovers its service provider and facade. No manual registration required.

### Publish Configuration

```bash
php artisan vendor:publish --tag=cubeconnect-config
```

### Environment Variables

Add your API key to `.env`:

```
CUBECONNECT_API_KEY=your_api_key_here
```

| Variable | Default | Description |
|----------|---------|-------------|
| `CUBECONNECT_API_KEY` | — | Your API key from the dashboard |
| `CUBECONNECT_URL` | `https://cubeconnect.io` | API base URL |
| `CUBECONNECT_TENANT_ID` | `null` | Tenant ID (multi-tenant only) |
| `CUBECONNECT_TIMEOUT` | `30` | Request timeout in seconds |

## Usage

### Sending a Text Message

```php
use CubeConnect\Facades\CubeConnect;

$response = CubeConnect::sendText('+966501234567', 'Your order has been confirmed.');

$response->status;               // "queued"
$response->messageLogId;         // 4521
$response->conversationCategory; // "SERVICE"
$response->queued();             // true
```

> **Note:** Text messages require the recipient to have messaged you within the last 24 hours. Outside this window, use a [template message](#sending-a-template-message).

### Sending a Template Message

```php
use CubeConnect\Facades\CubeConnect;

$response = CubeConnect::sendTemplate(
    '+966501234567',
    'order_confirmation',
    ['ORD-1234', '500 SAR']
);
```

Parameters map to `{{1}}`, `{{2}}`, etc. in the template body. Templates can be sent at any time.

### Health Check

```php
$health = CubeConnect::health();
// ['status' => 'healthy', 'checks' => [...], 'timestamp' => '...']
```

## Dependency Injection

You may inject the client using the contract or the concrete class:

```php
use CubeConnect\Contracts\Messaging;

class OrderController extends Controller
{
    public function shipped(Order $order, Messaging $messaging)
    {
        $messaging->sendTemplate(
            $order->customer_phone,
            'order_shipped',
            [$order->id, $order->tracking_number]
        );
    }
}
```

## Error Handling

The SDK throws specific exceptions for each error type. All exceptions include an `errorCode` property matching the [unified API error codes](https://developer.cubeconnect.io/api/errors):

```php
use CubeConnect\Facades\CubeConnect;
use CubeConnect\Exceptions\AuthenticationException;
use CubeConnect\Exceptions\ValidationException;
use CubeConnect\Exceptions\RateLimitException;
use CubeConnect\Exceptions\NotFoundException;
use CubeConnect\Exceptions\CubeConnectException;

try {
    CubeConnect::sendText('+966501234567', 'Hello!');
} catch (AuthenticationException $e) {
    // 401 — Invalid or missing API key
    // 403 — Insufficient permissions or tenant issues
    $e->errorCode;  // "INVALID_API_KEY", "AUTHENTICATION_REQUIRED",
                     // "API_KEY_NO_TENANT", "TENANT_NOT_FOUND", "FORBIDDEN"
    $e->statusCode; // 401 or 403
} catch (ValidationException $e) {
    // 422 — Invalid request data
    $e->errorCode; // "VALIDATION_ERROR", "NO_ACTIVE_ACCOUNT",
                   // "MISSING_ACCESS_TOKEN", "INVALID_PHONE_NUMBER"
    $e->errors;    // ['phone' => ['The phone field is required.']]
} catch (NotFoundException $e) {
    // 404 — Resource not found
    $e->errorCode; // "NOT_FOUND", "TEMPLATE_NOT_FOUND"
} catch (RateLimitException $e) {
    // 429 — Rate limit or plan limit exceeded
    $e->errorCode; // "RATE_LIMIT_EXCEEDED", "PLAN_LIMIT_REACHED", "SUBSCRIPTION_EXPIRED"
} catch (CubeConnectException $e) {
    // 5xx or network errors
    $e->errorCode;  // "INTERNAL_ERROR", "MESSAGE_SEND_FAILED", "CONNECTION_FAILED"
    $e->statusCode;
}
```

All exceptions extend `CubeConnectException`, so you can catch the base class for generic handling.

## Response Object

All message methods return a `MessageResponse` with the following properties:

| Property | Type | Description |
|----------|------|-------------|
| `status` | `string` | `queued` on success |
| `messageLogId` | `int` | Unique tracking ID |
| `conversationCategory` | `string` | `SERVICE`, `MARKETING`, `UTILITY`, or `AUTHENTICATION` |
| `cost` | `float` | Message cost |

```php
$response->queued();   // true if status is "queued"
$response->toArray();  // Array representation
```

## Architecture

The package follows SOLID principles:

- **`Contracts\Messaging`** — Interface for the messaging client. Bind your own implementation if needed.
- **`CubeConnect`** — Default implementation using Laravel's HTTP client.
- **`CubeConnectServiceProvider`** — Deferred provider that only loads when the service is used.
- **`Facades\CubeConnect`** — Static proxy backed by the `Messaging` contract.

## Documentation

Full API documentation is available at [developer.cubeconnect.io](https://developer.cubeconnect.io).

## License

CubeConnect for Laravel is open-sourced software licensed under the [MIT license](LICENSE).

Copyright © 2026 [Cube Software](https://cubeconnect.io) (CubeSoftLabs). All rights reserved.
