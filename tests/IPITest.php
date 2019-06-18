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
     * Instantiate and return an IPI object
     */
    private function instantiateIPI()
    {
        $ipi = new IPI();
        return $ipi;
    }
}
