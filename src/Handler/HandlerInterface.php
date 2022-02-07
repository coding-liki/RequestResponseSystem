<?php

namespace CodingLiki\RequestResponseSystem\Handler;

use CodingLiki\RequestResponseSystem\InternalRequestInterface;
use CodingLiki\RequestResponseSystem\ResponseProcessor\InternalResponseInterface;

/**
 * @template RequestClass of InternalRequestInterface
 * @method InternalResponseInterface run(InternalRequestInterface $request)
 */
interface HandlerInterface
{
    public function accepts(InternalRequestInterface $request): bool;

    public function setRequest(InternalRequestInterface $request): static;

    /**
     * @return RequestClass
     */
    public function getRequest(): mixed;

}