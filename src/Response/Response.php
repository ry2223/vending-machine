<?php

namespace VendingMachine\Response;

use VendingMachine\Money\MoneyCollectionInterface;

class Response implements ResponseInterface
{
    private $response;

    public function __construct($response)
    {
        $this->response = $response;
    }

	public function __toString(): string
    {
        return $this->response;
    }
}
