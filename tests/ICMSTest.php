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
     * Test CST 00
     */
    public function testCST00()
    {
        $icms = $this->instantiateICMS();
        $icms->setCST('00');
        $icms->vBC = 1000;
        $pICMS = 12;
        ICMS::calcular($icms, null, null, $pICMS, null);
        $this->assertSame(120.0, $icms->vICMS);
        $this->assertSame(0, $icms->vICMSST);
        $this->assertSame(0, $icms->vBCST);
        $this->assertSame(0, $icms->pMVAST);
        $this->assertSame(0, $icms->pICMSST);
    }

    /**
     * Instantiate and return an ICMS object
     */
    private function instantiateICMS()
    {
        $icms = new ICMS();
        $icms->setCST('');

        $icms->pRedBC = null;
        $icms->vBC = null;
        $icms->pICMS = null;
        $icms->vICMS = null;
        $icms->modBC = null;

        $icms->pMVAST = null;
        $icms->pRedBCST = null;
        $icms->vBCST = null;
        $icms->pICMSST = null;
        $icms->vICMSST = null;
        $icms->modBCST = null;

        $icms->vBCSTRet = null;
        $icms->vICMSSTRet = null;
        $icms->pCredSN = null;
        $icms->vCredICMSSN = null;
        $icms->SUFRAMA = null;
        $icms->Desconto = null;
        $icms->Zerar = null;
        $icms->vICMSDeson = null;
        $icms->CSTNotaRef = null;

        return $icms;
    }
}
