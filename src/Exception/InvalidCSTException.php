<?php

declare(strict_types=1);

namespace Gbbs\NfeCalculos\Exception;

use Throwable;

class InvalidCSTException extends \InvalidArgumentException implements \Throwable
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('CST ' . $message . ' invalid', $code, $previous);
    }
}
