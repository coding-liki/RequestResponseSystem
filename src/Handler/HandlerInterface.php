<?php

namespace CodingLiki\RequestResponseSystem\Handler;

use CodingLiki\RequestResponseSystem\InternalRequestInterface;
use CodingLiki\RequestResponseSystem\ResponseProcessor\InternalResponseInterface;

/**
 * @template RequestClass of InternalRequestInterface
 */
interface HandlerInterface
{
    public function accepts(InternalRequestInterface $request): bool;

    public function setRequest(InternalRequestInterface $request): static;

    /**
     * @return RequestClass
     */
    public function getRequest(): mixed;

    public function run(): InternalResponseInterface;
}