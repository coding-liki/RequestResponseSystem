<?php

namespace CodingLiki\RequestResponseSystem;

use Psr\Http\Message\ServerRequestInterface;

interface InternalRequestInterface
{
    public function getServerRequest(): ServerRequestInterface;
}