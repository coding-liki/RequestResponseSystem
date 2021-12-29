<?php

namespace CodingLiki\RequestResponseSystem;

use CodingLiki\RequestResponseSystem\ResponseProcessor\InternalResponseInterface;
use CodingLiki\RequestResponseSystem\ResponseProcessor\ResponseProcessorInterface;

class ResponseProcessorFabric
{
    /**
     * @param ResponseProcessorInterface[] $responseProcessors
     */
    public function __construct(private array $responseProcessors)
    {
    }

    public function build(InternalResponseInterface $response): ?ResponseProcessorInterface
    {
        foreach ($this->responseProcessors as $processor) {
            if ($processor->canProcess($response)) {
                return $processor;
            }
        }

        return NULL;
    }
}