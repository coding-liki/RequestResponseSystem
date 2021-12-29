<?php

namespace CodingLiki\RequestResponseSystem\RequestExtractor;

use CodingLiki\RequestResponseSystem\InternalRequestInterface;

interface RequestExtractorInterface
{
    public function extract(): ?InternalRequestInterface;
}