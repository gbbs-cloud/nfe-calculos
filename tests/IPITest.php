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
     * @expectedException \Exception
     */
    public function testCST00()
    {
        $ipi = $this->instantiateIPI();
        $ipi->setCST('00');

        IPI::calcular($ipi);
    }

    /**
     * Test CST 01
     * @expectedException \Exception
     */
    public function testCST01()
    {
        $ipi = $this->instantiateIPI();
        $ipi->setCST('01');

        IPI::calcular($ipi);
    }

    /**
     * Test CST 02
     * @expectedException \Exception
     */
    public function testCST02()
    {
        $ipi = $this->instantiateIPI();
        $ipi->setCST('02');

        IPI::calcular($ipi);
    }

    /**
     * Test CST 03
     * @expectedException \Exception
     */
    public function testCST03()
    {
        $ipi = $this->instantiateIPI();
        $ipi->setCST('03');

        IPI::calcular($ipi);
    }

    /**
     * Test CST 04
     * @expectedException \Exception
     */
    public function testCST04()
    {
        $ipi = $this->instantiateIPI();
        $ipi->setCST('04');

        IPI::calcular($ipi);
    }

    /**
     * Test CST 05
     * @expectedException \Exception
     */
    public function testCST05()
    {
        $ipi = $this->instantiateIPI();
        $ipi->setCST('05');

        IPI::calcular($ipi);
    }

    /**
     * Test CST 49
     * @expectedException \Exception
     */
    public function testCST49()
    {
        $ipi = $this->instantiateIPI();
        $ipi->setCST('49');

        IPI::calcular($ipi);
    }

    public function testCST50()
    {
        $ipi = $this->instantiateIPI();
        $ipi->setCST('50');
        $ipi->setVBC(1000.0);
        $ipi->setPIPI(12.0);

        IPI::calcular($ipi);

        $this->assertSame('50', $ipi->getCST());
        $this->assertSame(1000.0, $ipi->getVBC());
        $this->assertSame(12.0, $ipi->getPIPI());
    }

    public function testCST51()
    {
        $ipi = $this->instantiateIPI();
        $ipi->setCST('51');

        IPI::calcular($ipi);

        $this->assertSame('51', $ipi->getCST());
    }

    /**
     * Test CST 52
     * @expectedException \Exception
     */
    public function testCST52()
    {
        $ipi = $this->instantiateIPI();
        $ipi->setCST('52');

        IPI::calcular($ipi);
    }

    /**
     * Test CST 53
     * @expectedException \Exception
     */
    public function testCST53()
    {
        $ipi = $this->instantiateIPI();
        $ipi->setCST('53');

        IPI::calcular($ipi);
    }

    /**
     * Test CST 54
     * @expectedException \Exception
     */
    public function testCST54()
    {
        $ipi = $this->instantiateIPI();
        $ipi->setCST('54');

        IPI::calcular($ipi);
    }

    /**
     * Test CST 55
     * @expectedException \Exception
     */
    public function testCST55()
    {
        $ipi = $this->instantiateIPI();
        $ipi->setCST('55');

        IPI::calcular($ipi);
    }

    /**
     * Test CST 99
     * @expectedException \Exception
     */
    public function testCST99()
    {
        $ipi = $this->instantiateIPI();
        $ipi->setCST('99');

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
