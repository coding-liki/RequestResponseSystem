<?php

namespace CodingLiki\RequestResponseSystem\Middleware;

use CodingLiki\RequestResponseSystem\Handler\HandlerInterface;
use CodingLiki\RequestResponseSystem\InternalRequestInterface;
use CodingLiki\RequestResponseSystem\ResponseProcessor\InternalResponseInterface;
use Psr\Container\ContainerInterface;

abstract class BaseMiddleware implements MiddlewareInterface
{
    protected ?\Throwable $throwable = NULL;
    protected ?HandlerInterface $handler = NULL;
    protected ?InternalRequestInterface $request = NULL;
    protected ?InternalResponseInterface $response = NULL;
    private ContainerInterface $diContainer;

    public function before(): void
    {
    }

    public function after(): void
    {
    }

    public function setThrowable(?\Throwable $t): static
    {
        $this->throwable = $t;

        return $this;
    }

    public function setRequest(?InternalRequestInterface $request): static
    {
        $this->request = $request;

        return $this;
    }

    public function setResponse(?InternalResponseInterface $response): static
    {
        $this->response = $response;

        return $this;
    }

    public function setHandler(?HandlerInterface $handler): static
    {
        $this->handler = $handler;

        return $this;
    }

    public function setDiContainer(ContainerInterface $diContainer): static
    {
        $this->diContainer = $diContainer;

        return $this;
    }

    public function getDiContainer(): ContainerInterface
    {
        return $this->diContainer;
    }
}