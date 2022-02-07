<?php

namespace CodingLiki\RequestResponseSystem;

use CodingLiki\RequestResponseSystem\HandlerDecider\HandlerDeciderInterface;

class HandlerDeciderFabric
{
    /**
     * @param HandlerDeciderInterface[] $handlerDeciders
     */
    public function __construct(private array $handlerDeciders)
    {
    }

    public function build(InternalRequestInterface $request): ?HandlerDeciderInterface
    {
        foreach ($this->handlerDeciders as $handlerDecider) {
            if ($handlerDecider->canProcessRequest($request)) {
                return $handlerDecider;
            }
        }

        return NULL;
    }

}