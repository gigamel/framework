<?php

declare(strict_types=1);

namespace Slon\Http;

use Psr\Http\Message\RequestInterface;
use Slon\Http\Protocol\ClientMessage\Method;
use Slon\Http\Router\RouteInterface;
use Slon\Http\Router\RouteShardInterface;

use function array_filter;
use function preg_match;
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

    public function match(RequestInterface $message): ?RouteShardInterface
    {
        $rule = $this->getRule();
        foreach ($this->tokens as $id => $regEx) {
            $rule = str_replace(
                sprintf('{%s}', $id),
                sprintf('(?P<%s>%s)', $id, $regEx),
                $rule
            );
        }

        return (bool) preg_match(sprintf('~^%s$~', $rule), $message->getUri()->getPath(), $matches)
            ? new RouteShard($this->getHandler(), array_filter($matches))
            : null;
    }

    public function generate(array $segments = []): string
    {
        $rule = $this->getRule();
        foreach ($segments as $id => $segment) {
            $rule = str_replace(sprintf('{%s}', $id), (string)$segment, $rule);
        }

        preg_match('(\(/?\{[a-z_-]+\}/?\)\?)', $rule, $matches);
        foreach ($matches as $match) {
            $rule = str_replace($match, '', $rule);
        }

        return str_replace([')?', '('], ['', ''], $rule);
    }
}
