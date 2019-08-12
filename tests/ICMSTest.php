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
     * Test CST 20
     */
    public function testCST20()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $icms = $this->instantiateICMS();
        $icms->CST = '20';
        calcularICMS($icms, '11', '11');
    }

    /**
     * Test CST 30
     */
    public function testCST30()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $icms = $this->instantiateICMS();
        $icms->CST = '30';
        $icms->modBCST = 4;
        calcularICMS($icms, '11', '11');
    }

    /**
     * Test CST 40
     */
    public function testCST40()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $icms = $this->instantiateICMS();
        $icms->CST = '40';
        calcularICMS($icms, '11', '11');
    }

    /**
     * Test CST 41
     */
    public function testCST41()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $icms = $this->instantiateICMS();
        $icms->CST = '41';
        calcularICMS($icms, '11', '11');
    }

    /**
     * Test CST 50
     */
    public function testCST50()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $icms = $this->instantiateICMS();
        $icms->CST = '50';
        calcularICMS($icms, '11', '11');
    }

    /**
     * Test CST 51
     */
    public function testCST51()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $icms = $this->instantiateICMS();
        $icms->CST = '51';
        calcularICMS($icms, '11', '11');
    }

    /**
     * Test CST 60
     */
    public function testCST60()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $icms = $this->instantiateICMS();
        $icms->CST = '60';
        calcularICMS($icms, '11', '11');
    }

    /**
     * Test CST 70
     */
    public function testCST70()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $icms = $this->instantiateICMS();
        $icms->CST = '70';
        $icms->modBCST = 4;
        calcularICMS($icms, '11', '11');
    }

    /**
     * Test CST 90
     */
    public function testCST90()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $icms = $this->instantiateICMS();
        $icms->CST = '90';
        calcularICMS($icms, '11', '11');
    }

    /**
     * Test CST 101
     */
    public function testCST101()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $icms = $this->instantiateICMS();
        $icms->CST = '101';
        calcularICMS($icms, '11', '11');
    }

    /**
     * Test CST 102
     */
    public function testCST102()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $icms = $this->instantiateICMS();
        $icms->CST = '102';
        calcularICMS($icms, '11', '11');
    }

    /**
     * Test CST 103
     */
    public function testCST103()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $icms = $this->instantiateICMS();
        $icms->CST = '103';
        calcularICMS($icms, '11', '11');
    }

    /**
     * Test CST 200
     */
    public function testCST200()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $icms = $this->instantiateICMS();
        $icms->CST = '200';
        calcularICMS($icms, '11', '11');
    }

    /**
     * Test CST 201
     */
    public function testCST201()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $icms = $this->instantiateICMS();
        $icms->CST = '201';
        $icms->modBCST = 4;
        calcularICMS($icms, '11', '11');
    }

    /**
     * Test CST 202
     */
    public function testCST202()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $icms = $this->instantiateICMS();
        $icms->CST = '202';
        $icms->modBCST = 4;
        calcularICMS($icms, '11', '11');
    }

    /**
     * Test CST 203
     */
    public function testCST203()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $icms = $this->instantiateICMS();
        $icms->CST = '203';
        $icms->modBCST = 4;
        calcularICMS($icms, '11', '11');
    }

    /**
     * Test CST 300
     */
    public function testCST300()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $icms = $this->instantiateICMS();
        $icms->CST = '300';
        calcularICMS($icms, '11', '11');
    }

    /**
     * Test CST 400
     */
    public function testCST400()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $icms = $this->instantiateICMS();
        $icms->CST = '400';
        calcularICMS($icms, '11', '11');
    }

    /**
     * Test CST 500
     */
    public function testCST500()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $icms = $this->instantiateICMS();
        $icms->CST = '500';
        calcularICMS($icms, '11', '11');
    }

    /**
     * Test CST 900
     */
    public function testCST900()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $icms = $this->instantiateICMS();
        $icms->CST = '900';
        $icms->modBCST = 4;
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
