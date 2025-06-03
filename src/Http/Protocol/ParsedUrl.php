<?php

declare(strict_types=1);

namespace Slon\Http\Protocol;

final readonly class ParsedUrl
{
    public string $authority;
    
    public string $userInfo;
    
    public function __construct(
        public string $scheme = '',

        public string $host = '',

        public ?int $port = null,
        
        ?string $user = null,
        
        ?string $pass = null,

        public string $path = '',

        public string $query = '',

        public string $fragment = '',
    ) {
        if ($host) {
            $authority = $host;
            
            if ($user) {
                $pass = $pass ? \sprintf(':%s', $pass) : '';
                $authority = \sprintf('%s%s@%s', $user, $pass, $host);
                
                $userInfo = \sprintf('%s%s', $user, $pass);
            }
            
            if (null !== $port) {
                $authority = \sprintf('%s:%d', $authority, $port);
            }
        }
        
        $this->authority = $authority ?? '';
        $this->userInfo = $userInfo ?? '';
    }
    
    public function __toString(): string
    {
        return \sprintf(
            '%s%s%s%s%s%s%s',
            $this->scheme ? $this->scheme . '://' : '',
            $this->user ? $this->user . ($this->pass ? ':' . $this->pass : '') . '@' : '',
            $this->host,
            $this->port === null ? '' : ':' . $this->port,
            $this->path,
            $this->query ? '?' . $this->query : '',
            $this->fragment ? '#' . $this->fragment : '',
        );
    }
}
