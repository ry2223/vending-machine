<?php

namespace VendingMachine\Response;

class Response implements ResponseInterface
{
    public function __construct(
        private string $response,
    ) {}

	public function __toString(): string
    {
        return $this->response;
    }
}
