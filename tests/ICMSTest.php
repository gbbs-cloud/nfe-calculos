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
        ICMS::calcular(null, null, null, null, null);
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
     * @expectedException \Exception
     */
    public function testInvalidCST()
    {
        $icms = $this->instantiateICMS();
        $icms->setCST('00000');
        ICMS::calcular($icms, null, null, null, null);
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

        ICMS::calcular($icms, null, null, null, null);

        $this->assertSame('0', $icms->getOrig());
        $this->assertSame('00', $icms->getCST());
        $this->assertSame(0, $icms->getModBC());
        $this->assertSame(1000.0, $icms->getVBC());
        $this->assertSame(12.0, $icms->getPICMS());
        $this->assertSame(120.0, $icms->getVICMS());
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
