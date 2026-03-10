<?php

namespace App\DTOs;

use Illuminate\Http\Request;

readonly class LoginData
{
    /**
     * Create a new class instance from Request.
     */
    public function __construct(
        public int $user_id,
        public string $ip_address,
        public string $user_agent,
        public string $session_id,
        public ?string $logged_out_at = null,
    ) {}

    /**
     * Factory method from Request.
     */
    public static function fromRequest(Request $request, int $user_id): self
    {
        return new self(
            user_id: $user_id,
            ip_address: $request->ip() ?? '127.0.0.1',
            user_agent: $request->userAgent() ?? 'CLI/Unknown',
            session_id: $request->hasSession() ? $request->session()->getId() : 'no-session',
        );
    }

    /**
     * Convert to array for database storage.
     */
    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id,
            'ip_address' => $this->ip_address,
            'user_agent' => $this->user_agent,
            'session_id' => $this->session_id,
            'logged_in_at' => now(),
        ];
    }
}
