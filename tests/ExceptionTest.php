<?php

declare(strict_types=1);

namespace Gbbs\NfeCalculos\Tests;

use Gbbs\NfeCalculos\Exception\InvalidCSTException;
use Gbbs\NfeCalculos\Exception\NotImplementedCSTException;
use PHPUnit\Framework\TestCase;

class ExceptionTest extends TestCase
{
    /**
     * Test InvalidCSTException message
     */
    public function testInvalidCSTException()
    {
        try {
            throw new InvalidCSTException('123');
        } catch (InvalidCSTException $exception) {
            $this->assertEquals('CST 123 invalid', $exception->getMessage());
            $this->assertEquals(0, $exception->getCode());
        }
    }

    /**
     * Test NotImplementedCSTException message
     */
    public function testNotImplementedCSTExceptionMessage()
    {
        try {
            throw new NotImplementedCSTException('123');
        } catch (NotImplementedCSTException $exception) {
            $this->assertEquals('CST 123 not implemented', $exception->getMessage());
            $this->assertEquals(0, $exception->getCode());
        }
    }
}
