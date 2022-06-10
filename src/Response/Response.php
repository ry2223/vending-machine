<?php

namespace VendingMachine\Response;

class Response
{
    private string $response;

    public function __construct(string $response)
    {
        $this->response = $response;
    }

	public function __toString(): string
    {
        return $this->response;
    }
}
