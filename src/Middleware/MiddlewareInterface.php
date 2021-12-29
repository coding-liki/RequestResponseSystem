<?php

namespace CodingLiki\RequestResponseSystem\Middleware;

use CodingLiki\RequestResponseSystem\Handler\HandlerInterface;
use CodingLiki\RequestResponseSystem\InternalRequestInterface;
use CodingLiki\RequestResponseSystem\ResponseProcessor\InternalResponseInterface;

interface MiddlewareInterface
{
    public function before(): void;

    public function after(): void;

    public function setThrowable(\Throwable $t): static;

    public function setRequest(?InternalRequestInterface $request): static;

    public function setResponse(?InternalResponseInterface $response): static;

    public function setHandler(?HandlerInterface $handler): static;
}

