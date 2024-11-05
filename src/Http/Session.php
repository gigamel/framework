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
    /**
     * @inheritDoc
     */
    public function start(array $options = []): bool
    {
        if (PHP_SESSION_DISABLED === $this->getStatus()) {
            throw new SessionException('Session disabled');
        }

        if (PHP_SESSION_ACTIVE === $this->getStatus()) {
            return true;
        }

        return session_start();
    }

    public function getStatus(): int
    {
        return session_status();
    }

    /**
     * @inheritDoc
     */
    public function set(string $key, mixed $value): void
    {
        $key = trim($key);
        if (!preg_match('/^[a-zA-Z]+([a-zA-Z0-9_][a-zA-Z])?/', $key)) {
            $this->abort();
            throw new SessionException('Invalid session key');
        }

        $_SESSION[$key] = $value;
    }

    public function get(string $key): mixed
    {
        return $_SESSION[$key] ?? null;
    }

    public function abort(): bool
    {
        if (PHP_SESSION_ACTIVE === $this->getStatus()) {
            session_abort();
        }
        return PHP_SESSION_NONE === $this->getStatus();
    }

    public function __destruct()
    {
        $this->abort();
    }
}
