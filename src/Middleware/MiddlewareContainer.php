<?php

namespace CodingLiki\RequestResponseSystem\Middleware;

use CodingLiki\DiContainer\DiContainer;
use CodingLiki\RequestResponseSystem\Handler\HandlerInterface;
use CodingLiki\RequestResponseSystem\InternalRequestInterface;

class MiddlewareContainer
{
    private array $handlerMiddlewares = [];
    private array $requestMiddlewares = [];
    private array $globalRequestMiddlewares = [];
    private array $globalHandlersMiddlewares = [];

    public function __construct(private DiContainer $diContainer)
    {
    }

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
            $middlewares = array_merge(
                $this->globalRequestMiddlewares,
                $this->requestMiddlewares[$request::class] ?? []
            );
        }

        return array_map(
            fn(MiddlewareInterface $middleware) => $middleware->setRequest($request)->setDiContainer($this->diContainer),
            $middlewares
        );
    }

    /**
     * @return MiddlewareInterface[]
     */
    public function getByHandler(?HandlerInterface $handler): array
    {
        $middlewares = $this->globalHandlersMiddlewares;

        if ($handler !== NULL) {
            $middlewares = array_merge(
                $this->globalHandlersMiddlewares,
                $this->handlerMiddlewares[$handler::class] ?? []
            );
        }

        return array_map(
            fn(MiddlewareInterface $middleware) => $middleware->setHandler($handler)->setDiContainer($this->diContainer),
            $middlewares
        );
    }
}

