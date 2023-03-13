<?php

declare(strict_types=1);

namespace Gbbs\NfeCalculos\Tests;

use Gbbs\NfeCalculos\IPI;
use PHPUnit\Framework\TestCase;

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
        $this->expectExceptionMessage('CST 00000 invalid');
        $this->expectExceptionCode(0);
        $ipi = $this->instantiateIPI();
        $ipi->CST = '00000';

        IPI::calcularIPI($ipi);
    }

    /**
     * Test invalid NCM
     */
    public function testInvalidNCM()
    {
        $this->expectException('\Exception');
        IPI::pIPIFromNCM('020750100');
    }

    /**
     * Test NCM with NCMAli === 'NT'
     */
    public function testNCMWithNCMAliNT()
    {
        $pIPI = IPI::pIPIFromNCM('01012100');
        $this->assertSame(0.0, $pIPI);
    }

    /**
     * Test NCM with NCMAli !== 'NT' and NCMAli !== '0'
     */
    public function testNCMWithNCMAliNotNT()
    {
        $pIPI = IPI::pIPIFromNCM('22011000');
        $this->assertSame(15.0, $pIPI);
    }

    /**
     * Test not implemented CST
     */
    public function testNotImplementedCST()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $this->expectExceptionMessage('CST 02 not implemented');
        $this->expectExceptionCode(0);
        $ipi = $this->instantiateIPI();
        $ipi->CST = '02';

        IPI::calcularIPI($ipi);
    }

    /**
     * Test CST with adValoremIPI with pIPI === 0
     */
    public function testAdValoremIPI()
    {
        $ipi = $this->instantiateIPI();
        $ipi->cEnq = '999';
        $ipi->CST = '50';
        $ipi->vBC = 1000.0;
        $ipi->pIPI = IPI::pIPIFromNCM('02075100');
        $calculado = IPI::calcularIPI($ipi);

        $this->assertSame('999', $calculado->cEnq);
        $this->assertSame('50', $calculado->CST);
        $this->assertSame(1000.0, $calculado->vBC);
        $this->assertSame(0.0, $calculado->pIPI);
        $this->assertSame(0.0, $calculado->vIPI);
    }

    /**
     * Test CST with adValoremIPI with pIPI !== 0
     */
    public function testAdValoremIPIWithPIPI()
    {
        $ipi = $this->instantiateIPI();
        $ipi->cEnq = '999';
        $ipi->CST = '50';
        $ipi->vBC = 1000.0;
        $ipi->pIPI = IPI::pIPIFromNCM('22011000');
        $calculado = IPI::calcularIPI($ipi);

        $this->assertSame('999', $calculado->cEnq);
        $this->assertSame('50', $calculado->CST);
        $this->assertSame(1000.0, $calculado->vBC);
        $this->assertSame(15.0, $calculado->pIPI);
        $this->assertSame(150.0, $calculado->vIPI);
    }

    /**
     * Test adValoremIPI with CST === '00'
     */
    public function testAdValoremIPIWithCST00()
    {
        $ipi = $this->instantiateIPI();
        $ipi->cEnq = '999';
        $ipi->CST = '00';
        $ipi->vBC = 1000.0;
        $ipi->pIPI = IPI::pIPIFromNCM('22011000');
        $calculado = IPI::calcularIPI($ipi);

        $this->assertSame('999', $calculado->cEnq);
        $this->assertSame('00', $calculado->CST);
        $this->assertSame(1000.0, $calculado->vBC);
        $this->assertSame(15.0, $calculado->pIPI);
        $this->assertSame(150.0, $calculado->vIPI);
    }

    /**
     * Test CST with isentoIPI
     */
    public function testIsentoIPI()
    {
        $ipi = $this->instantiateIPI();
        $ipi->cEnq = '999';
        $ipi->CST = '51';
        $ipi->pIPI = IPI::pIPIFromNCM('02075100');

        $calculado = IPI::calcularIPI($ipi);

        $this->assertSame('999', $calculado->cEnq);
        $this->assertSame('51', $calculado->CST);
        $this->assertSame(0.0, $calculado->vBC);
        $this->assertSame(0.0, $calculado->pIPI);
        $this->assertSame(0.0, $calculado->vIPI);
    }

    /**
     * Test CST with 01
     */
    public function testCST01()
    {

        $ipi = $this->instantiateIPI();
        $ipi->cEnq = '999';
        $ipi->CST = '01';
        $ipi->pIPI = IPI::pIPIFromNCM('02075100');

        $calculado = IPI::calcularIPI($ipi);

        $this->assertSame('999', $calculado->cEnq);
        $this->assertSame('01', $calculado->CST);
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
