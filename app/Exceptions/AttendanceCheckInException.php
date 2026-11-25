<?php

namespace App\Exceptions;

use RuntimeException;

/** Kegagalan check-in yang dapat dijelaskan kepada pengguna (bukan error sistem). */
class AttendanceCheckInException extends RuntimeException
{
    public const TOKEN_INVALID = 'token_invalid';
    public const SESSION_CLOSED = 'session_closed';
    public const SESSION_EXPIRED = 'session_expired';
    public const NOT_STARTED = 'not_started';
    public const ALREADY_CHECKED_IN = 'already_checked_in';
    public const FORBIDDEN_ROLE = 'forbidden_role';
    public const TOO_MANY_ATTEMPTS = 'too_many_attempts';

    private const HTTP_STATUS = [
        self::TOKEN_INVALID => 422,
        self::SESSION_CLOSED => 422,
        self::SESSION_EXPIRED => 422,
        self::NOT_STARTED => 422,
        self::ALREADY_CHECKED_IN => 409,
        self::FORBIDDEN_ROLE => 403,
        self::TOO_MANY_ATTEMPTS => 429,
    ];

    public function __construct(public readonly string $reason, string $message)
    {
        parent::__construct($message);
    }

    public function httpStatus(): int
    {
        return self::HTTP_STATUS[$this->reason] ?? 422;
    }
}
