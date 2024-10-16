<?php declare(strict_types=1);

namespace Gigamel\Http\Router;

use Gigamel\Http\Protocol\ClientMessageInterface;
use Gigamel\Http\Protocol\ClientMessage\Method;

class Route implements RouteInterface
{
    protected const string REGEX_FORMAT = '~^%s$~';

    protected const string SEGMENT_FORMAT = '{%s}';

    protected const string REGEX_SEGMENT_FORMAT = '(?P<%s>%s)';

    protected array $segments = [];

    public function __construct(
        protected string $name,
        protected string $rule,
        protected string $handler,
        array $tokens = [],
        protected array $methods = [Method::GET, Method::POST]
    ) {
        $this->tokens = array_filter(
            $tokens,
            static function ($id, $regEx): bool {
                return is_string($key) && is_string($value);
            },
            ARRAY_FILTER_USE_BOTH
        );
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

    public function match(ClientMessageInterface $message): bool
    {
        $rule = $this->getRule();
        foreach ($this->tokens as $id => $regEx) {
            $rule = sprintf(self::REGEX_SEGMENT_FORMAT, $id, $regEx);
        }

        $matched = (bool) preg_match(
            sprintf(self::REGEX_FORMAT, $rule),
            $message->getPath(),
            $matches
        );

        if ($matched) {
            $this->segments = array_filter($matches, 'is_string');
            return true;
        }

        return false;
    }

    public function generate(array $segments = []): string
    {
        $rule = $this->getRule();
        foreach ($segments as $id => $segment) {
            $rule = str_replace(sprintf(self::SEGMENT_FORMAT, $id), $segment, $rule);
        }
        return $rule;
    }

    /**
     * @inheritDoc
     */
    public function getSegments(): array
    {
        return $this->segments;
    }
}
