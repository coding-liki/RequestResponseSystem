<?php

namespace CodingLiki\RequestResponseSystem\Middleware;

use CodingLiki\RequestResponseSystem\Handler\HandlerInterface;
use CodingLiki\RequestResponseSystem\InternalRequestInterface;

class MiddlewareContainer
{
    private array $handlerMiddlewares        = [];
    private array $requestMiddlewares        = [];
    private array $globalRequestMiddlewares  = [];
    private array $globalHandlersMiddlewares = [];

    /**
     * @param MiddlewareInterface[] $middlewares
     */
    public function addByHandlerClass(?string $class, array $middlewares): static
    {
        foreach ($middlewares as $middleware) {
            if ($class === NULL) {
                if (!in_array($middleware, $this->globalHandlersMiddlewares)) {
                    $this->globalHandlersMiddlewares[] = $middleware;
                }
            } else {
                if (!in_array($middleware, $this->handlerMiddlewares[$class] ?? [])) {
                    $this->handlerMiddlewares[$class][] = $middleware;
                }
            }
        }

        return $this;
    }

    /**
     * @param MiddlewareInterface[] $middlewares
     */
    public function addByRequestClass(?string $class, array $middlewares): static
    {
        foreach ($middlewares as $middleware) {
            if ($class === NULL) {
                if (!in_array($middleware, $this->globalRequestMiddlewares)) {
                    $this->globalRequestMiddlewares[] = $middleware;
                }
            } else {
                if (!in_array($middleware, $this->requestMiddlewares[$class] ?? [])) {
                    $this->requestMiddlewares[$class][] = $middleware;
                }
            }
        }

        return $this;
    }

    /**
     * @return MiddlewareInterface[]
     */
    public function getByRequest(?InternalRequestInterface $request): array
    {
        $middlewares = $this->globalRequestMiddlewares;

        if ($request !== NULL) {
            $middlewares = array_merge($middlewares, $this->requestMiddlewares[$request::class] ?? []);
        }

        return $middlewares;
    }

    /**
     * @return MiddlewareInterface[]
     */
    public function getByHandler(?HandlerInterface $handler): array
    {
        $middlewares = $this->globalHandlersMiddlewares;

        if ($handler !== NULL) {
            $middlewares = array_merge($middlewares, $this->handlerMiddlewares[$handler::class] ?? []);
        }

        return $middlewares;
    }
}

