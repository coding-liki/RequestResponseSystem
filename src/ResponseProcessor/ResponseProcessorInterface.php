<?php

namespace CodingLiki\RequestResponseSystem\ResponseProcessor;

interface ResponseProcessorInterface
{
    public function canProcess(InternalResponseInterface $response): bool;

    public function process(InternalResponseInterface $response);
}