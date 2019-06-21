<?php

declare(strict_types=1);

namespace Gbbs\NfeCalculos;

use PHPUnit\Framework\TestCase;

class ICMSTest extends TestCase
{
    /**
     * @expectedException \TypeError
     */
    public function testFailingNullArgument()
    {
        ICMS::calcular(null, null, null);
    }

    /**
     * Test that object is Instance of ICMS
     */
    public function testIsInstanceICMS()
    {
        $icms = $this->instantiateICMS();
        $this->assertInstanceOf(ICMS::class, $icms);
    }

    /**
     * Test properties types
     */
    public function testPropertiesTypes()
    {
        $icms = $this->instantiateICMS();
        $icms->setOrig('');
        $icms->setCST('');
        $icms->setModBC(1);
        $icms->setPRedBC(1.0);
        $icms->setVBC(1.0);
        $icms->setPICMS(1.0);
        $icms->setVICMS(1.0);
        $icms->setModBCST(1);
        $icms->setPMVAST(1.0);
        $icms->setPRedBCST(1.0);
        $icms->setVBCST(1.0);
        $icms->setPICMSST(1.0);
        $icms->setVICMSST(1.0);
        $icms->setUFST('');
        $icms->setPBCop(1.0);
        $icms->setVBCSTRet(1.0);
        $icms->setVICMSSTRet(1.0);
        $icms->setMotDesICMS(1);
        $icms->setVBCSTDest(1.0);
        $icms->setVICMSSTDest(1.0);
        $icms->setPCredSN(1.0);
        $icms->setVCredICMSSN(1.0);
        $icms->setVICMSDeson(1.0);
        $icms->setVICMSOp(1.0);
        $icms->setPDif(1.0);
        $icms->setVICMSDif(1.0);
        $icms->setVBCFCP(1.0);
        $icms->setPFCP(1.0);
        $icms->setVFCP(1.0);
        $icms->setVBCFCPST(1.0);
        $icms->setPFCPST(1.0);
        $icms->setVFCPST(1.0);
        $icms->setVBCFCPSTRet(1.0);
        $icms->setPFCPSTRet(1.0);
        $icms->setVFCPSTRet(1.0);
        $icms->setPST(1.0);

        $this->assertIsString($icms->getOrig());
        $this->assertIsString($icms->getCST());
        $this->assertIsInt($icms->getModBC());
        $this->assertIsFloat($icms->getPRedBC());
        $this->assertIsFloat($icms->getVBC());
        $this->assertIsFloat($icms->getPICMS());
        $this->assertIsFloat($icms->getVICMS());
        $this->assertIsInt($icms->getModBCST());
        $this->assertIsFloat($icms->getPMVAST());
        $this->assertIsFloat($icms->getPRedBCST());
        $this->assertIsFloat($icms->getVBCST());
        $this->assertIsFloat($icms->getPICMSST());
        $this->assertIsFloat($icms->getVICMSST());
        $this->assertIsString($icms->getUFST());
        $this->assertIsFloat($icms->getPBCop());
        $this->assertIsFloat($icms->getVBCSTRet());
        $this->assertIsFloat($icms->getVICMSSTRet());
        $this->assertIsInt($icms->getMotDesICMS());
        $this->assertIsFloat($icms->getVBCSTDest());
        $this->assertIsFloat($icms->getVICMSSTDest());
        $this->assertIsFloat($icms->getPCredSN());
        $this->assertIsFloat($icms->getVCredICMSSN());
        $this->assertIsFloat($icms->getVICMSDeson());
        $this->assertIsFloat($icms->getVICMSOp());
        $this->assertIsFloat($icms->getPDif());
        $this->assertIsFloat($icms->getVICMSDif());
        $this->assertIsFloat($icms->getVBCFCP());
        $this->assertIsFloat($icms->getPFCP());
        $this->assertIsFloat($icms->getVFCP());
        $this->assertIsFloat($icms->getVBCFCPST());
        $this->assertIsFloat($icms->getPFCPST());
        $this->assertIsFloat($icms->getVFCPST());
        $this->assertIsFloat($icms->getVBCFCPSTRet());
        $this->assertIsFloat($icms->getPFCPSTRet());
        $this->assertIsFloat($icms->getVFCPSTRet());
        $this->assertIsFloat($icms->getPST());
    }

    /**
     * Test invalid CST
     * @expectedException \Gbbs\NfeCalculos\Exception\InvalidCSTException
     */
    public function testInvalidCST()
    {
        $icms = $this->instantiateICMS();
        $icms->setCST('00000');

        ICMS::calcular($icms, null, null);
    }

    /**
     * Test CST 00 with modBC === 0
     */
    public function testCST00ModBC0()
    {
        $icms = $this->instantiateICMS();
        $icms->setOrig('0');
        $icms->setCST('00');
        $icms->setModBC(0);
        $icms->setVBC(1000);
        $icms->setPICMS(12);

        ICMS::calcular($icms, null, null);

        $this->assertSame('0', $icms->getOrig());
        $this->assertSame('00', $icms->getCST());
        $this->assertSame(0, $icms->getModBC());
        $this->assertSame(1000.0, $icms->getVBC());
        $this->assertSame(12.0, $icms->getPICMS());
        $this->assertSame(120.0, $icms->getVICMS());
    }

    /**
     * Test CST 00 with modBC !== 0
     * modBC === 1, modBC === 2 and modBC === 3 aren't implemented
     * @expectedException \Exception
     */
    public function testCST00ModBCDifferentThan1()
    {
        $icms = $this->instantiateICMS();
        $icms->setOrig('0');
        $icms->setCST('00');
        $icms->setModBC(1);
        $icms->setVBC(1000);
        $icms->setPICMS(12);

        ICMS::calcular($icms, null, null);
    }

    /**
     * Test CST 10
     * modBCST === 4
     * pRedBCST === 1.0
     * pMVAST === 10.0
     */
    public function testCST10ModBCST4PRedBCST1()
    {
        $icms = $this->instantiateICMS();
        $icms->setOrig('0');
        $icms->setCST('10');
        $icms->setModBC(0);
        $icms->setVBC(100);
        $icms->setPICMS(1);
        $icms->setModBCST(4);
        $icms->setPMVAST(10.0);
        $icms->setPRedBCST(1);
        $icms->setVBCST(1);
        $icms->setPICMSST(1);

        ICMS::calcular($icms, null, null);

        $this->assertSame('0', $icms->getOrig());
        $this->assertSame('10', $icms->getCST());
        $this->assertSame(0, $icms->getModBC());
        $this->assertSame(100.0, $icms->getVBC());
        $this->assertSame(1.0, $icms->getPICMS());
        $this->assertSame(1.0, $icms->getVICMS());
        $this->assertSame(4, $icms->getModBCST());
        $this->assertSame(10.0, $icms->getPMVAST());
        $this->assertSame(1.0, $icms->getPRedBCST());
        $this->assertSame(1.089, $icms->getVBCST());
        $this->assertSame(null, $icms->getPICMSST());
        $this->assertSame(-1.0, $icms->getVICMSST());
    }

    /**
     * Test CST 10
     * modBCST === 4
     * pRedBCST === 0.0
     * pMVAST === 0.0
     */
    public function testCST10ModBCST4PRedBCST()
    {
        $icms = $this->instantiateICMS();
        $icms->setOrig('0');
        $icms->setCST('10');
        $icms->setModBC(0);
        $icms->setVBC(100);
        $icms->setPICMS(1);
        $icms->setModBCST(4);
        $icms->setPMVAST(0.0);
        $icms->setPRedBCST(0);
        $icms->setVBCST(1);
        $icms->setPICMSST(1);

        ICMS::calcular($icms, null, null);

        $this->assertSame('0', $icms->getOrig());
        $this->assertSame('10', $icms->getCST());
        $this->assertSame(0, $icms->getModBC());
        $this->assertSame(100.0, $icms->getVBC());
        $this->assertSame(1.0, $icms->getPICMS());
        $this->assertSame(1.0, $icms->getVICMS());
        $this->assertSame(4, $icms->getModBCST());
        $this->assertSame(0.0, $icms->getPMVAST());
        $this->assertSame(0.0, $icms->getPRedBCST());
        $this->assertSame(1.0, $icms->getVBCST());
        $this->assertSame(null, $icms->getPICMSST());
        $this->assertSame(0.0, $icms->getVICMSST());
    }

    /**
     * Test CST 10
     * modBCST !== 4
     * modBCST === 0, modBCST === 1, modBCST === 2, modBCST === 3 and modBCST === 5 aren't implemented
     * @expectedException \Exception
     */
    public function testCST10ModBCSTDifferentThan4()
    {
        $icms = $this->instantiateICMS();
        $icms->setOrig('0');
        $icms->setCST('10');
        $icms->setModBC(0);
        $icms->setVBC(100);
        $icms->setPICMS(1);
        $icms->setModBCST(0);
        $icms->setPMVAST(0.0);
        $icms->setPRedBCST(0);
        $icms->setVBCST(1);
        $icms->setPICMSST(1);

        ICMS::calcular($icms, null, null);
    }

    /**
     * Test CST 20
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST20()
    {
        $icms = $this->instantiateICMS();
        $icms->setCST('20');
        ICMS::calcular($icms, null, null);
    }

    /**
     * Test CST 30
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST30()
    {
        $icms = $this->instantiateICMS();
        $icms->setCST('30');
        $icms->setModBCST(4);
        ICMS::calcular($icms, null, null);
    }

    /**
     * Test CST 40
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST40()
    {
        $icms = $this->instantiateICMS();
        $icms->setCST('40');
        ICMS::calcular($icms, null, null);
    }

    /**
     * Test CST 41
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST41()
    {
        $icms = $this->instantiateICMS();
        $icms->setCST('41');
        ICMS::calcular($icms, null, null);
    }

    /**
     * Test CST 50
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST50()
    {
        $icms = $this->instantiateICMS();
        $icms->setCST('50');
        ICMS::calcular($icms, null, null);
    }

    /**
     * Test CST 51
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST51()
    {
        $icms = $this->instantiateICMS();
        $icms->setCST('51');
        ICMS::calcular($icms, null, null);
    }

    /**
     * Test CST 60
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST60()
    {
        $icms = $this->instantiateICMS();
        $icms->setCST('60');
        ICMS::calcular($icms, null, null);
    }

    /**
     * Test CST 70
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST70()
    {
        $icms = $this->instantiateICMS();
        $icms->setCST('70');
        $icms->setModBCST(4);
        ICMS::calcular($icms, null, null);
    }

    /**
     * Test CST 90
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST90()
    {
        $icms = $this->instantiateICMS();
        $icms->setCST('90');
        ICMS::calcular($icms, null, null);
    }

    /**
     * Test CST 101
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST101()
    {
        $icms = $this->instantiateICMS();
        $icms->setCST('101');
        ICMS::calcular($icms, null, null);
    }

    /**
     * Test CST 102
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST102()
    {
        $icms = $this->instantiateICMS();
        $icms->setCST('102');
        ICMS::calcular($icms, null, null);
    }

    /**
     * Test CST 103
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST103()
    {
        $icms = $this->instantiateICMS();
        $icms->setCST('103');
        ICMS::calcular($icms, null, null);
    }

    /**
     * Test CST 200
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST200()
    {
        $icms = $this->instantiateICMS();
        $icms->setCST('200');
        ICMS::calcular($icms, null, null);
    }

    /**
     * Test CST 201
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST201()
    {
        $icms = $this->instantiateICMS();
        $icms->setCST('201');
        $icms->setModBCST(4);
        ICMS::calcular($icms, null, null);
    }

    /**
     * Test CST 202
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST202()
    {
        $icms = $this->instantiateICMS();
        $icms->setCST('202');
        $icms->setModBCST(4);
        ICMS::calcular($icms, null, null);
    }

    /**
     * Test CST 203
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST203()
    {
        $icms = $this->instantiateICMS();
        $icms->setCST('203');
        $icms->setModBCST(4);
        ICMS::calcular($icms, null, null);
    }

    /**
     * Test CST 300
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST300()
    {
        $icms = $this->instantiateICMS();
        $icms->setCST('300');
        ICMS::calcular($icms, null, null);
    }

    /**
     * Test CST 400
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST400()
    {
        $icms = $this->instantiateICMS();
        $icms->setCST('400');
        ICMS::calcular($icms, null, null);
    }

    /**
     * Test CST 500
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST500()
    {
        $icms = $this->instantiateICMS();
        $icms->setCST('500');
        ICMS::calcular($icms, null, null);
    }

    /**
     * Test CST 900
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST900()
    {
        $icms = $this->instantiateICMS();
        $icms->setCST('900');
        $icms->setModBCST(4);
        ICMS::calcular($icms, null, null);
    }

    /**
     * Instantiate and return an ICMS object
     */
    private function instantiateICMS()
    {
        $icms = new ICMS();
        return $icms;
    }
}
