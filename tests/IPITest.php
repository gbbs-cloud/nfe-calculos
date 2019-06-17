<?php

declare(strict_types=1);

namespace Gbbs\NfeCalculos;

use PHPUnit\Framework\TestCase;

class IPITest extends TestCase
{
    /**
     * @expectedException \TypeError
     */
    public function testFailingNullArgument()
    {
        IPI::calcular(null, null);
    }

    /**
     * Test that object is Instance of IPI
     */
    public function testIsInstanceIPI()
    {
        $ipi = $this->instantiateIPI();
        $this->assertInstanceOf(IPI::class, $ipi);
    }

    /**
     * Instantiate and return an IPI object
     */
    private function instantiateIPI()
    {
        $ipi = new IPI();
        return $ipi;
    }
}
