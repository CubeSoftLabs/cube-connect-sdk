<?php

namespace CubeConnect\DTOs;

class MessageResponse
{
    /**
     * Create a new message response instance.
     *
     * @param  string  $status
     * @param  int  $messageLogId
     * @param  string  $conversationCategory
     * @param  float  $cost
     * @return void
     */
    public function __construct(
        public readonly string $status,
        public readonly int $messageLogId,
        public readonly string $conversationCategory,
        public readonly float $cost,
    ) {}

    /**
     * Create a new instance from an API response array.
     *
     * @param  array<string, mixed>  $data
     * @return static
     */
    public static function fromResponse(array $data): static
    {
        return new static(
            status: $data['status'] ?? '',
            messageLogId: (int) ($data['message_log_id'] ?? 0),
            conversationCategory: $data['conversation_category'] ?? '',
            cost: (float) ($data['cost'] ?? 0),
        );
    }

    /**
     * Determine if the message was successfully queued.
     *
     * @return bool
     */
    public function queued(): bool
    {
        return $this->status === 'queued';
    }

    /**
     * Get the response as an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'status' => $this->status,
            'message_log_id' => $this->messageLogId,
            'conversation_category' => $this->conversationCategory,
            'cost' => $this->cost,
        ];
    }
}
