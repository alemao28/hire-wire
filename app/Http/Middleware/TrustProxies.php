<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array<int, string>|string|null
     */
    protected $proxies = '*';  // Asterisco (*) para confiar em todos os proxies, ajuste conforme necessário

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers = \Illuminate\Http\Request::HEADER_X_FORWARDED_FOR |
                          \Illuminate\Http\Request::HEADER_X_FORWARDED_HOST |
                          \Illuminate\Http\Request::HEADER_X_FORWARDED_PORT |
                          \Illuminate\Http\Request::HEADER_X_FORWARDED_PROTO;
}
