<?php

namespace CodingLiki\RequestResponseSystem\HandlerDecider;

use CodingLiki\RequestResponseSystem\Handler\HandlerInterface;
use CodingLiki\RequestResponseSystem\InternalRequestInterface;

/**
 * @template RequestClass
 */
interface HandlerDeciderInterface
{

    public function canProcessRequest(InternalRequestInterface $request): bool;

    /**
     * @param RequestClass $request
     */
    public function getHandler(InternalRequestInterface $request): ?HandlerInterface;
}