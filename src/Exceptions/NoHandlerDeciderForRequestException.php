<?php

namespace CodingLiki\RequestResponseSystem\Exceptions;

use CodingLiki\RequestResponseSystem\InternalRequestInterface;

class NoHandlerDeciderForRequestException extends \Exception
{
    public function __construct(private InternalRequestInterface $request)
    {
        parent::__construct("There is no handler decider for request " . $request->getServerRequest()->getMethod() . " " . $request->getServerRequest()->getUri());
    }

    public function getRequest(): InternalRequestInterface
    {
        return $this->request;
    }
}