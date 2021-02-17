<?php

declare(strict_types=1);

namespace Gbbs\NfeCalculos\Tests;

use Gbbs\NfeCalculos\IPI;
use PHPUnit\Framework\TestCase;

use function Gbbs\NfeCalculos\calcularIPI;
use function Gbbs\NfeCalculos\pIPIFromNCM;

class IPITest extends TestCase
{
    /**
     * Test that object is Instance of IPI
     */
    public function testIsInstanceIPI()
    {
        $ipi = $this->instantiateIPI();
        $this->assertInstanceOf(IPI::class, $ipi);
    }

    /**
     * Test invalid CST
     */
    public function testInvalidCST()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\InvalidCSTException');
        $ipi = $this->instantiateIPI();
        $ipi->CST = '00000';

        $calculado = calcularIPI($ipi);
    }

    /**
     * Test invalid NCM
     */
    public function testInvalidNCM()
    {
        $this->expectException('\Exception');
        pIPIFromNCM('020750100');
    }

    /**
     * Test not implemented CST
     */
    public function testNotImplementedCST()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $ipi = $this->instantiateIPI();
        $ipi->CST = '01';

        calcularIPI($ipi);
    }

    /**
     * Test CST with adValoremIPI
     */
    public function testAdValoremIPI()
    {
        $ipi = $this->instantiateIPI();
        $ipi->cEnq = '999';
        $ipi->CST = '50';
        $ipi->vBC = 1000.0;
        $ipi->pIPI = pIPIFromNCM('02075100');
        $calculado = calcularIPI($ipi);

        $this->assertSame('999', $calculado->cEnq);
        $this->assertSame('50', $calculado->CST);
        $this->assertSame(1000.0, $calculado->vBC);
        $this->assertSame(0.0, $calculado->pIPI);
        $this->assertSame(0.0, $calculado->vIPI);
    }

    /**
     * Test CST with isentoIPI
     */
    public function testIsentoIPI()
    {
        $ipi = $this->instantiateIPI();
        $ipi->cEnq = '999';
        $ipi->CST = '51';
        $ipi->pIPI = pIPIFromNCM('02075100');

        $calculado = calcularIPI($ipi);

        $this->assertSame('999', $calculado->cEnq);
        $this->assertSame('51', $calculado->CST);
        $this->assertSame(0.0, $calculado->vBC);
        $this->assertSame(0.0, $calculado->pIPI);
        $this->assertSame(0.0, $calculado->vIPI);
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
