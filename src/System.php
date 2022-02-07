<?php

namespace CodingLiki\RequestResponseSystem;

use CodingLiki\RequestResponseSystem\Exceptions\MethodNotImplementedException;
use CodingLiki\RequestResponseSystem\Exceptions\NoHandlerDeciderForRequestException;
use CodingLiki\RequestResponseSystem\Exceptions\NoHandlerForRequestException;
use CodingLiki\RequestResponseSystem\Exceptions\NoResponseProcessorForResponseException;
use CodingLiki\RequestResponseSystem\Middleware\MiddlewareContainer;

class System
{
    public function __construct(
        private RequestFabric           $requestFabric,
        private HandlerDeciderFabric    $handlerDeciderFabric,
        private ResponseProcessorFabric $responseProcessorFabric,
        private MiddlewareContainer     $middlewareContainer
    )
    {
    }

    public function process()
    {
        try {
            $request = $this->requestFabric->build();

            if ($request === NULL) {
                throw new MethodNotImplementedException();
            }

            $this->requestMiddlewaresBefore($request);
            $handlerDecider = $this->handlerDeciderFabric->build($request);

            if ($handlerDecider === NULL) {
                throw new NoHandlerDeciderForRequestException($request);
            }

            $handler = $handlerDecider->getHandler($request);

            if ($handler === NULL) {
                throw new NoHandlerForRequestException($request);
            }

            $this->handlerMiddlewaresBefore($handler);

            $handler->setRequest($request);
            $response = $handler->run($request);

            $responseProcessor = $this->responseProcessorFabric->build($response);

            if ($responseProcessor === NULL) {
                throw new NoResponseProcessorForResponseException($response);
            }

            $responseProcessor->process($response);
        } catch (\Throwable $t) {
            $throwable = $t;
        } finally {
            $this->handlerMiddlewaresAfter($handler ?? NULL, $throwable ?? NULL, $request ?? NULL, $response ?? NULL);

            $this->requestMiddlewaresAfter($request ?? NULL, $throwable ?? NULL, $response ?? NULL);
        }
    }

    private function requestMiddlewaresAfter(?InternalRequestInterface $request, \Throwable|\Exception|null $throwable, ?ResponseProcessor\InternalResponseInterface $response): void
    {
        $requestMiddlewares = $this->middlewareContainer->getByRequest($request ?? NULL);

        foreach ($requestMiddlewares as $middleware) {
            $middleware
                ->setThrowable($throwable ?? NULL)
                ->setRequest($request ?? NULL)
                ->setResponse($response ?? NULL)
                ->after();
        }
    }

    private function handlerMiddlewaresAfter(?Handler\HandlerInterface $handler, \Throwable|\Exception|null $throwable, ?InternalRequestInterface $request, ?ResponseProcessor\InternalResponseInterface $response): void
    {
        $handlersMiddlewares = $this->middlewareContainer->getByHandler($handler ?? NULL);

        foreach ($handlersMiddlewares as $middleware) {
            $middleware
                ->setThrowable($throwable ?? NULL)
                ->setRequest($request ?? NULL)
                ->setResponse($response ?? NULL)
                ->setHandler($handler ?? NULL)
                ->after();
        }
    }

    private function requestMiddlewaresBefore(InternalRequestInterface $request)
    {
        $requestMiddlewares = $this->middlewareContainer->getByRequest($request);

        foreach ($requestMiddlewares as $middleware) {
            $middleware
                ->setRequest($request)
                ->before();
        }
    }

    private function handlerMiddlewaresBefore(Handler\HandlerInterface $handler)
    {
        $handlersMiddlewares = $this->middlewareContainer->getByHandler($handler);

        foreach ($handlersMiddlewares as $middleware) {
            $middleware
                ->setHandler($handler)
                ->before();
        }
    }
}

