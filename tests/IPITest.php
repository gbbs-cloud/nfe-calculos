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
        $ipi = $this->instantiateIPI();
        $ipi->CST = '00';
        $ipi->pIPI = pIPIFromNCM('020750100');

        $calculado = calcularIPI($ipi);
    }

    /**
     * Test CST 00
     */
    public function testCST00()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $ipi = $this->instantiateIPI();
        $ipi->CST = '00';
        $ipi->pIPI = pIPIFromNCM('02075100');

        $calculado = calcularIPI($ipi);
    }

    /**
     * Test CST 01
     */
    public function testCST01()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $ipi = $this->instantiateIPI();
        $ipi->CST = '01';
        $ipi->pIPI = pIPIFromNCM('02075100');

        $calculado = calcularIPI($ipi);
    }

    /**
     * Test CST 02
     */
    public function testCST02()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $ipi = $this->instantiateIPI();
        $ipi->CST = '02';
        $ipi->pIPI = pIPIFromNCM('02075100');

        $calculado = calcularIPI($ipi);
    }

    /**
     * Test CST 03
     */
    public function testCST03()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $ipi = $this->instantiateIPI();
        $ipi->CST = '03';
        $ipi->pIPI = pIPIFromNCM('02075100');

        $calculado = calcularIPI($ipi);
    }

    /**
     * Test CST 04
     */
    public function testCST04()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $ipi = $this->instantiateIPI();
        $ipi->CST = '04';
        $ipi->pIPI = pIPIFromNCM('02075100');

        $calculado = calcularIPI($ipi);
    }

    /**
     * Test CST 05
     */
    public function testCST05()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $ipi = $this->instantiateIPI();
        $ipi->CST = '05';
        $ipi->pIPI = pIPIFromNCM('02075100');

        $calculado = calcularIPI($ipi);
    }

    /**
     * Test CST 49
     */
    public function testCST49()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $ipi = $this->instantiateIPI();
        $ipi->CST = '49';
        $ipi->pIPI = pIPIFromNCM('02075100');

        $calculado = calcularIPI($ipi);
    }

    public function testCST50()
    {
        $ipi = $this->instantiateIPI();
        $ipi->CST = '50';
        $ipi->vBC = 1000.0;
        $ipi->pIPI = pIPIFromNCM('02075100');

        $calculado = calcularIPI($ipi);

        $this->assertSame('50', $calculado->CST);
        $this->assertSame(1000.0, $calculado->vBC);
        $this->assertSame(0.0, $calculado->pIPI);
    }

    public function testCST51()
    {
        $ipi = $this->instantiateIPI();
        $ipi->CST = '51';
        $ipi->pIPI = pIPIFromNCM('02075100');

        $calculado = calcularIPI($ipi);

        $this->assertSame('51', $calculado->CST);
    }

    /**
     * Test CST 52
     */
    public function testCST52()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $ipi = $this->instantiateIPI();
        $ipi->CST = '52';
        $ipi->pIPI = pIPIFromNCM('02075100');

        $calculado = calcularIPI($ipi);
    }

    /**
     * Test CST 53
     */
    public function testCST53()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $ipi = $this->instantiateIPI();
        $ipi->CST = '53';
        $ipi->pIPI = pIPIFromNCM('02075100');

        $calculado = calcularIPI($ipi);
    }

    /**
     * Test CST 54
     */
    public function testCST54()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $ipi = $this->instantiateIPI();
        $ipi->CST = '54';
        $ipi->pIPI = pIPIFromNCM('02075100');

        $calculado = calcularIPI($ipi);
    }

    /**
     * Test CST 55
     */
    public function testCST55()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $ipi = $this->instantiateIPI();
        $ipi->CST = '55';
        $ipi->pIPI = pIPIFromNCM('02075100');

        $calculado = calcularIPI($ipi);
    }

    /**
     * Test CST 99
     */
    public function testCST99()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $ipi = $this->instantiateIPI();
        $ipi->CST = '99';
        $ipi->pIPI = pIPIFromNCM('02075100');

        $calculado = calcularIPI($ipi);
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
