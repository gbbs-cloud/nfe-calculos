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
        IPI::calcular(null);
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
        $ipi->setPIPI(1.0);
        $ipi->setVIPI(1.0);
        $ipi->setQUnid(1.0);
        $ipi->setVUnid(1.0);

        $this->assertIsString($ipi->getCNPJProd());
        $this->assertIsString($ipi->getCSelo());
        $this->assertIsFloat($ipi->getQSelo());
        $this->assertIsString($ipi->getCEnq());
        $this->assertIsString($ipi->getCST());
        $this->assertIsFloat($ipi->getVBC());
        $this->assertIsFloat($ipi->getPIPI());
        $this->assertIsFloat($ipi->getVIPI());
        $this->assertIsFloat($ipi->getQUnid());
        $this->assertIsFloat($ipi->getVUnid());
    }

    /**
     * Test invalid CST
     * @expectedException \Exception
     */
    public function testInvalidCST()
    {
        $ipi = $this->instantiateIPI();
        $ipi->setCST('00000');

        IPI::calcular($ipi);
    }

    /**
     * Test CST 00
     */
    public function testCST00()
    {
        $ipi = $this->instantiateIPI();
        $ipi->setCST('00');
        $ipi->setVBC(1000.0);
        $ipi->setPIPI(12.0);

        IPI::calcular($ipi);

        $this->assertSame('00', $ipi->getCST());
        $this->assertSame(1000.0, $ipi->getVBC());
        $this->assertSame(12.0, $ipi->getPIPI());
        $this->assertSame(120.0, $ipi->getVIPI());
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
