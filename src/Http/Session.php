<?php declare(strict_types=1);

namespace Gigamel\Http;

use Gigamel\Http\Server\SessionException;
use Gigamel\Http\Server\SessionInterface;

use function preg_match;
use function session_abort;
use function session_status;
use function session_start;

class Session implements SessionInterface
{
    protected const string REGEX_KEY = '[a-zA-Z]+([a-zA-Z0-9_][a-zA-Z])?';

    public function __construct(protected readonly array $options = [])
    {
        if (PHP_SESSION_DISABLED === $this->getStatus()) {
            throw new SessionException('Session disabled');
        }
    }

    public function start(): bool
    {
        return session_start($this->options);
    }

    public function getStatus(): int
    {
        return session_status();
    }

    public function set(string $key, mixed $value): void
    {
        if ($this->isValidKey($key)) {
            $_SESSION[$key] = $value;
        }
    }

    public function get(string $key): mixed
    {
        return $_SESSION[$key] ?? null;
    }

    public function exists(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function remove(string $key): bool
    {
        if ($this->exists($key)) {
            unset($_SESSION[$key]);
        }
    }

    public function abort(): bool
    {
        if ($this->isActive()) {
            session_abort();
        }
        return $this->isInactive();
    }

    protected function isValidKey(string $key): bool
    {
        return (bool) preg_match(sprintf('/^%s$/', self::REGEX_KEY), $key);
    }

    protected function isActive(): bool
    {
        return PHP_SESSION_ACTIVE === $this->getStatus();
    }

    protected function isDisabled(): bool
    {
        return PHP_SESSION_DISABLED === $this->getStatus();
    }

    protected function isInactive(): bool
    {
        return PHP_SESSION_NONE === $this->getStatus();
    }
}
