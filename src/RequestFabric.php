<?php

namespace CodingLiki\RequestResponseSystem;

use CodingLiki\RequestResponseSystem\RequestExtractor\RequestExtractorInterface;

class RequestFabric
{
    /**
     * @param RequestExtractorInterface[] $requestExtractors
     */
    public function __construct(private array $requestExtractors)
    {
    }

    public function build(): ?InternalRequestInterface
    {
        foreach ($this->requestExtractors as $extractor) {
            $request = $extractor->extract();

            if ($request instanceof InternalRequestInterface) {
                return $request;
            }
        }

        return NULL;
    }
}