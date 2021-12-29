<?php

namespace CodingLiki\RequestResponseSystem\Exceptions;

use CodingLiki\RequestResponseSystem\ResponseProcessor\InternalResponseInterface;

class NoResponseProcessorForResponseException extends \Exception
{
    public function __construct(private InternalResponseInterface $response)
    {
        parent::__construct("No response processor for response class " . $this->response::class);
    }

    public function getResponse(): InternalResponseInterface
    {
        return $this->response;
    }
}