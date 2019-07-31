<?php

declare(strict_types=1);

namespace Gbbs\NfeCalculos\Tests;

use PHPUnit\Framework\TestCase;
use Gbbs\NfeCalculos\IPI;

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
     * Test properties types
     */
    public function testPropertiesTypes()
    {
        $ipi = $this->instantiateIPI();
        $ipi->setCNPJProd('');
        $ipi->setCSelo('');
        $ipi->setQSelo(1.0);
        $ipi->setCEnq('');
        $ipi->setCST('');
        $ipi->setVBC(1.0);
        $ipi->setVIPI(1.0);
        $ipi->setQUnid(1.0);
        $ipi->setVUnid(1.0);

        $this->assertIsString($ipi->getCNPJProd());
        $this->assertIsString($ipi->getCSelo());
        $this->assertIsFloat($ipi->getQSelo());
        $this->assertIsString($ipi->getCEnq());
        $this->assertIsString($ipi->getCST());
        $this->assertIsFloat($ipi->getVBC());
        $this->assertIsFloat($ipi->getVIPI());
        $this->assertIsFloat($ipi->getQUnid());
        $this->assertIsFloat($ipi->getVUnid());
    }

    /**
     * Test invalid CST
     */
    public function testInvalidCST()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\InvalidCSTException');
        $ipi = $this->instantiateIPI();
        $ipi->setCST('00000');

        IPI::calcular($ipi, '02075100');
    }

    /**
     * Test CST 00
     */
    public function testCST00()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $ipi = $this->instantiateIPI();
        $ipi->setCST('00');

        IPI::calcular($ipi, '02075100');
    }

    /**
     * Test CST 01
     */
    public function testCST01()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $ipi = $this->instantiateIPI();
        $ipi->setCST('01');

        IPI::calcular($ipi, '02075100');
    }

    /**
     * Test CST 02
     */
    public function testCST02()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $ipi = $this->instantiateIPI();
        $ipi->setCST('02');

        IPI::calcular($ipi, '02075100');
    }

    /**
     * Test CST 03
     */
    public function testCST03()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $ipi = $this->instantiateIPI();
        $ipi->setCST('03');

        IPI::calcular($ipi, '02075100');
    }

    /**
     * Test CST 04
     */
    public function testCST04()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $ipi = $this->instantiateIPI();
        $ipi->setCST('04');

        IPI::calcular($ipi, '02075100');
    }

    /**
     * Test CST 05
     */
    public function testCST05()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $ipi = $this->instantiateIPI();
        $ipi->setCST('05');

        IPI::calcular($ipi, '02075100');
    }

    /**
     * Test CST 49
     */
    public function testCST49()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $ipi = $this->instantiateIPI();
        $ipi->setCST('49');

        IPI::calcular($ipi, '02075100');
    }

    public function testCST50()
    {
        $ipi = $this->instantiateIPI();
        $ipi->setCST('50');
        $ipi->setVBC(1000.0);

        IPI::calcular($ipi, '02075100');

        $this->assertSame('50', $ipi->getCST());
        $this->assertSame(1000.0, $ipi->getVBC());
        $this->assertSame(0.0, $ipi->getPIPI());
    }

    public function testCST51()
    {
        $ipi = $this->instantiateIPI();
        $ipi->setCST('51');

        IPI::calcular($ipi, '02075100');

        $this->assertSame('51', $ipi->getCST());
    }

    /**
     * Test CST 52
     */
    public function testCST52()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $ipi = $this->instantiateIPI();
        $ipi->setCST('52');

        IPI::calcular($ipi, '02075100');
    }

    /**
     * Test CST 53
     */
    public function testCST53()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $ipi = $this->instantiateIPI();
        $ipi->setCST('53');

        IPI::calcular($ipi, '02075100');
    }

    /**
     * Test CST 54
     */
    public function testCST54()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $ipi = $this->instantiateIPI();
        $ipi->setCST('54');

        IPI::calcular($ipi, '02075100');
    }

    /**
     * Test CST 55
     */
    public function testCST55()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $ipi = $this->instantiateIPI();
        $ipi->setCST('55');

        IPI::calcular($ipi, '02075100');
    }

    /**
     * Test CST 99
     */
    public function testCST99()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $ipi = $this->instantiateIPI();
        $ipi->setCST('99');

        IPI::calcular($ipi, '02075100');
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
