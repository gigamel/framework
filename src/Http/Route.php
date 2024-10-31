<?php declare(strict_types=1);

namespace Gigamel\Http;

use Gigamel\Http\Protocol\ClientMessageInterface;
use Gigamel\Http\Protocol\ClientMessage\Method;

use function array_filter;
use function str_replace;

class Route implements RouteInterface
{
    public function __construct(
        protected string $name,
        protected string $rule,
        protected string $handler,
        protected array $tokens = [],
        protected array $methods = [Method::GET, Method::POST]
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRule(): string
    {
        return $this->rule;
    }

    public function getHandler(): string
    {
        return $this->handler;
    }

    public function getTokens(): array
    {
        return $this->tokens;
    }

    /**
     * @inheritDoc
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    public function match(ClientMessageInterface $message): ?RouteRestInterface
    {
        $rule = $this->getRule();
        foreach ($this->tokens as $id => $regEx) {
            $rule = sprintf('(?P<%s>%s)', $id, $regEx);
        }

        return (bool) preg_match(sprintf('~^%s$~', $rule), $message->getPath(), $matches)
            ? new RouteRest($this->getHandler(), $matches)
            : null;
    }

    public function generate(array $segments = []): string
    {
        $rule = $this->getRule();
        foreach ($segments as $id => $segment) {
            $rule = str_replace(sprintf('{%s}', $id), $segment, $rule);
        }
        return str_replace([')?', '('], ['', ''], $rule);
    }
}
