<?php

declare(strict_types=1);

namespace Gbbs\NfeCalculos;

use PHPUnit\Framework\TestCase;

class ICMSTest extends TestCase
{
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
     */
    public function testInvalidCST()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\InvalidCSTException');
        $icms = $this->instantiateICMS();
        $icms->CST = '00000';

        calcularICMS($icms, '11', '11');
    }

    /**
     * Test invalid UFs
     */
    public function testInvalidUFsInpICMSFromUFs()
    {
        $this->expectException('\Exception');
        pICMSFromUFs('1', '1');
    }

    /**
     * Test invalid UFs
     */
    public function testInvalidUFsInpICMSSTFromUFs()
    {
        $this->expectException('\Exception');
        pICMSSTFromUFs('1', '1');
    }

    /**
     * Test reducao
     */
    public function testReducao()
    {
        $icms = $this->instantiateICMS();
        $icms->orig = '0';
        $icms->CST = '00';
        $icms->modBC = 0;
        $icms->vBC = 1000;

        calcularICMS($icms, '11', '11', 10.0);

        $this->assertSame('0', $icms->orig);
        $this->assertSame('00', $icms->CST);
        $this->assertSame(0, $icms->modBC);
        $this->assertSame(1000, $icms->vBC);
        $this->assertSame(10.0, $icms->pICMS);
        $this->assertSame(100.0, $icms->vICMS);
    }

    /**
     * Test CST 00 with modBC === 0
     */
    public function testCST00ModBC0()
    {
        $icms = $this->instantiateICMS();
        $icms->orig = '0';
        $icms->CST = '00';
        $icms->modBC = 0;
        $icms->vBC = 1000;

        calcularICMS($icms, '11', '11');

        $this->assertSame('0', $icms->orig);
        $this->assertSame('00', $icms->CST);
        $this->assertSame(0, $icms->modBC);
        $this->assertSame(1000, $icms->vBC);
        $this->assertSame(17.0, $icms->pICMS);
        $this->assertSame(170.0, $icms->vICMS);
    }

    /**
     * Test CST 00 with modBC !== 0
     * modBC === 1, modBC === 2 and modBC === 3 aren't implemented
     */
    public function testCST00ModBCDifferentThan1()
    {
        $this->expectException('\Exception');
        $icms = $this->instantiateICMS();
        $icms->orig = '0';
        $icms->CST = '00';
        $icms->modBC = 1;
        $icms->vBC = 1000;

        calcularICMS($icms, '11', '11');
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
        $icms->orig = ('0');
        $icms->CST = '10';
        $icms->modBC = (0);
        $icms->vBC = (100);
        $icms->modBCST = (4);
        $icms->pMVAST = (10.0);
        $icms->pRedBCST = (1);
        $icms->pBCST = (1);

        calcularICMS($icms, '11', '11');

        $this->assertSame('0', $icms->orig);
        $this->assertSame('10', $icms->CST);
        $this->assertSame(0, $icms->modBC);
        $this->assertSame(100, $icms->vBC);
        $this->assertSame(17.0, $icms->pICMS);
        $this->assertSame(17.0, $icms->vICMS);
        $this->assertSame(4, $icms->modBCST);
        $this->assertSame(10.0, $icms->pMVAST);
        $this->assertSame(1, $icms->pRedBCST);
        $this->assertSame(0.0, $icms->vBCST);
        $this->assertSame(17.0, $icms->pICMSST);
        $this->assertSame(-17.0, $icms->vICMSST);
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
        $icms->orig = '0';
        $icms->CST = '10';
        $icms->modBC = 0;
        $icms->vBC = 100;
        $icms->modBCST = 4;
        $icms->pMVAST = 0.0;
        $icms->pRedBCST = 0;
        $icms->vBCST = 1;

        calcularICMS($icms, '11', '11');

        $this->assertSame('0', $icms->orig);
        $this->assertSame('10', $icms->CST);
        $this->assertSame(0, $icms->modBC);
        $this->assertSame(100, $icms->vBC);
        $this->assertSame(17.0, $icms->pICMS);
        $this->assertSame(17.0, $icms->vICMS);
        $this->assertSame(4, $icms->modBCST);
        $this->assertSame(0.0, $icms->pMVAST);
        $this->assertSame(0, $icms->pRedBCST);
        $this->assertSame(1.0, $icms->vBCST);
        $this->assertSame(17.0, $icms->pICMSST);
        $this->assertSame(0.0, $icms->vICMSST);
    }

    /**
     * Test CST 10
     * modBCST !== 4
     * modBCST === 0, modBCST === 1, modBCST === 2, modBCST === 3 and modBCST === 5 aren't implemented
     */
    public function testCST10ModBCSTDifferentThan4()
    {
        $this->expectException('\Exception');
        $icms = $this->instantiateICMS();
        $icms->orig = ('0');
        $icms->CST = '10';
        $icms->modBC = (0);
        $icms->vBC = (100);
        $icms->modBCST = (0);
        $icms->pMVAST = (0.0);
        $icms->pRedBCST = (0);
        $icms->vBCST = (1);

        calcularICMS($icms, '11', '11');
    }

    /**
     * Test not implemented CST
     */
    public function testNotImplementedCST()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $icms = $this->instantiateICMS();
        $icms->CST = '20';
        calcularICMS($icms, '11', '11');
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
