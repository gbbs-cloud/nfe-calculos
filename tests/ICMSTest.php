<?php

declare(strict_types=1);

namespace Gbbs\NfeCalculos\Tests;

use Gbbs\NfeCalculos\ICMS;
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
        $this->expectExceptionMessage('CST 00000 invalid');
        $this->expectExceptionCode(0);
        $icms = $this->instantiateICMS();
        $icms->CST = '00000';

        ICMS::calcularICMS($icms, '11', '11');
    }

    /**
     * Test invalid UFs
     */
    public function testInvalidUFsInpICMSFromUFs()
    {
        $this->expectException('\Exception');
        ICMS::pICMSFromUFs('1', '1');
    }

    /**
     * Test invalid UFs
     */
    public function testInvalidUFsInpICMSSTFromUFs()
    {
        $this->expectException('\Exception');
        ICMS::pICMSSTFromUFs('1', '1');
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
        $icms->vBC = 1234.56;

        $calculado = ICMS::calcularICMS($icms, '11', '11', 10.0, 10.0);

        $this->assertSame('0', $calculado->orig);
        $this->assertSame('00', $calculado->CST);
        $this->assertSame(0, $calculado->modBC);
        $this->assertSame(1234.56, $calculado->vBC);
        $this->assertSame(10.0, $calculado->pICMS);
        $this->assertSame(123.46, $calculado->vICMS);
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
        $icms->vBC = 1234.56;

        $calculado = ICMS::calcularICMS($icms, '11', '11');

        $this->assertSame('0', $calculado->orig);
        $this->assertSame('00', $calculado->CST);
        $this->assertSame(0, $calculado->modBC);
        $this->assertSame(1234.56, $calculado->vBC);
        $this->assertSame(17.5, $calculado->pICMS);
        $this->assertSame(216.05, $calculado->vICMS);
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
        $icms->vBC = 1234.56;

        ICMS::calcularICMS($icms, '11', '11');
    }

    /**
     * Test CST 10
     * modBCST === 4
     * pRedBCST === 1.0
     * pMVAST === 0.0
     */
    public function testCST10ModBCST4PRedBCST1()
    {
        $icms = $this->instantiateICMS();
        $icms->orig = '0';
        $icms->CST = '10';
        $icms->modBC = 0;
        $icms->vBC = 100.0;
        $icms->modBCST = 4;
        $icms->vBCST = 100.0;
        $icms->pMVAST = 0.0;
        $icms->pRedBCST = 1;

        $calculado = ICMS::calcularICMS($icms, '11', '11');

        $this->assertSame('0', $calculado->orig);
        $this->assertSame('10', $calculado->CST);
        $this->assertSame(0, $calculado->modBC);
        $this->assertSame(100.0, $calculado->vBC);
        $this->assertSame(17.5, $calculado->pICMS);
        $this->assertSame(17.5, $calculado->vICMS);
        $this->assertSame(4, $calculado->modBCST);
        $this->assertSame(0.0, $calculado->pMVAST);
        $this->assertSame(1, $calculado->pRedBCST);
        $this->assertSame(99.0, $calculado->vBCST);
        $this->assertSame(17.5, $calculado->pICMSST);
        $this->assertSame(0.0, $calculado->vICMSST);
    }

    /**
     * Test CST 10
     * modBCST === 4
     * pRedBCST === 0.0
     * pMVAST === 37.0
     */
    public function testCST10ModBCST4PRedBCST()
    {
        $icms = $this->instantiateICMS();
        $icms->orig = '0';
        $icms->CST = '10';
        $icms->modBC = 0;
        $icms->vBC = 144.0;
        $icms->modBCST = 4;
        $icms->vBCST = 144.0;
        $icms->pMVAST = 37.0;
        $icms->pRedBCST = 0.0;

        $calculado = ICMS::calcularICMS($icms, '43', '43');

        $this->assertSame('0', $calculado->orig);
        $this->assertSame('10', $calculado->CST);
        $this->assertSame(0, $calculado->modBC);
        $this->assertSame(144.0, $calculado->vBC);
        $this->assertSame(17.0, $calculado->pICMS);
        $this->assertSame(24.48, $calculado->vICMS);
        $this->assertSame(4, $calculado->modBCST);
        $this->assertSame(37.0, $calculado->pMVAST);
        $this->assertSame(0.0, $calculado->pRedBCST);
        $this->assertSame(197.28, $calculado->vBCST);
        $this->assertSame(17.0, $calculado->pICMSST);
        $this->assertSame(9.06, $calculado->vICMSST);
    }

    /**
     * Test CST 10
     * modBCST === 4
     * pRedBCST === 20.0
     * pMVAST === 37.0
     */
    public function testCST10ModBCST4PRedBCST10PMVAST37()
    {
        $icms = $this->instantiateICMS();
        $icms->orig = '0';
        $icms->CST = '10';
        $icms->modBC = 0;
        $icms->vBC = 144.0;
        $icms->modBCST = 4;
        $icms->vBCST = 144.0;
        $icms->pMVAST = 37.0;
        $icms->pRedBCST = 10.0;

        $calculado = ICMS::calcularICMS($icms, '43', '43');

        $this->assertSame('0', $calculado->orig);
        $this->assertSame('10', $calculado->CST);
        $this->assertSame(0, $calculado->modBC);
        $this->assertSame(144.0, $calculado->vBC);
        $this->assertSame(17.0, $calculado->pICMS);
        $this->assertSame(24.48, $calculado->vICMS);
        $this->assertSame(4, $calculado->modBCST);
        $this->assertSame(37.0, $calculado->pMVAST);
        $this->assertSame(10.0, $calculado->pRedBCST);
        $this->assertSame(177.55, $calculado->vBCST);
        $this->assertSame(17.0, $calculado->pICMSST);
        $this->assertSame(2.69, $calculado->vICMSST);
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
        $icms->orig = '0';
        $icms->CST = '10';
        $icms->modBC = 0;
        $icms->vBC = 100;
        $icms->modBCST = 0;
        $icms->pMVAST = 0.0;
        $icms->pRedBCST = 0;
        $icms->vBCST = 1;

        ICMS::calcularICMS($icms, '11', '11');
    }

    /**
     * Test CST 10
     * modBCST === 4
     * pRedBCST === 1.0
     * pMVAST === 0.0
     * ufDestino === 99
     */
    public function testCST10ModBCST4PRedBCST1UFDestino99()
    {
        $icms = $this->instantiateICMS();
        $icms->orig = '0';
        $icms->CST = '10';
        $icms->modBC = 0;
        $icms->vBC = 100.0;
        $icms->modBCST = 4;
        $icms->vBCST = 100.0;
        $icms->pMVAST = 0.0;
        $icms->pRedBCST = 1;

        $calculado = ICMS::calcularICMS($icms, '11', '99');

        $this->assertSame('0', $calculado->orig);
        $this->assertSame('10', $calculado->CST);
        $this->assertSame(0, $calculado->modBC);
        $this->assertSame(100.0, $calculado->vBC);
        $this->assertSame(0.0, $calculado->pICMS);
        $this->assertSame(0.0, $calculado->vICMS);
        $this->assertSame(4, $calculado->modBCST);
        $this->assertSame(0.0, $calculado->pMVAST);
        $this->assertSame(1, $calculado->pRedBCST);
        $this->assertSame(99.0, $calculado->vBCST);
        $this->assertSame(0.0, $calculado->pICMSST);
        $this->assertSame(0.0, $calculado->vICMSST);
    }

    /**
     * Test CST 41
     */
    public function testCST41()
    {
        $icms = $this->instantiateICMS();
        $icms->orig = '0';
        $icms->CST = '41';
        $icms->vBC = 100;
        $icms->motDesICMS = 9;

        $calculado = ICMS::calcularICMS($icms, '11', '11');

        $this->assertSame('0', $calculado->orig);
        $this->assertSame('41', $calculado->CST);
        $this->assertSame(17.5, $calculado->vICMSDeson);
        $this->assertSame(9, $calculado->motDesICMS);
        $this->assertSame(0.0, $calculado->vBC);
        $this->assertSame(0.0, $calculado->vICMS);
        $this->assertSame(0.0, $calculado->pICMS);
    }

    /**
     * Test CST 41 Exterior
     */
    public function testCST41Exterior()
    {
        $icms = $this->instantiateICMS();
        $icms->orig = '0';
        $icms->CST = '41';
        $icms->vBC = 100;
        $icms->motDesICMS = 9;

        $calculado = ICMS::calcularICMS($icms, '11', '99');

        $this->assertSame('0', $calculado->orig);
        $this->assertSame('41', $calculado->CST);
        $this->assertSame(0.0, $calculado->vICMSDeson);
        $this->assertSame(9, $calculado->motDesICMS);
    }

    /**
     * Test CST 50
     */
    public function testCST50()
    {
        $icms = $this->instantiateICMS();
        $icms->orig = '0';
        $icms->CST = '50';

        $calculado = ICMS::calcularICMS($icms, '11', '11');

        $this->assertSame('0', $calculado->orig);
        $this->assertSame('50', $calculado->CST);
        $this->assertSame(0.0, $calculado->vBC);
        $this->assertSame(0.0, $calculado->vICMS);
        $this->assertSame(0.0, $calculado->pICMS);
        $this->assertSame(0.0, $calculado->vICMSST);
        $this->assertSame(0.0, $calculado->vBCST);
        $this->assertSame(0.0, $calculado->pMVAST);
        $this->assertSame(0.0, $calculado->pICMSST);
    }

    /**
     * Test CST 51 with modBC === 3
     */
    public function testCST51ModBC3()
    {
        $icms = $this->instantiateICMS();
        $icms->CST = '51';
        $icms->vBC = 100.0;
        $icms->modBC = 3;
        $icms->pDif = 31.428;

        $calculado = ICMS::calcularICMS($icms, '43', '43');

        $this->assertSame('0', $calculado->orig);
        $this->assertSame('51', $calculado->CST);
        $this->assertSame(3, $calculado->modBC);
        $this->assertSame(100.0, $calculado->vBC);
        $this->assertSame(17.0, $calculado->pICMS);
        $this->assertSame(11.66, $calculado->vICMS);
        $this->assertSame(17.0, $calculado->vICMSOp);
        $this->assertSame(31.428, $calculado->pDif);
        $this->assertSame(5.34, $calculado->vICMSDif);
    }

    /**
     * Test CST 51 with modBC === 3 and pDif === 40.0
     */
    public function testCST51ModBC3PDif40()
    {
        $icms = $this->instantiateICMS();
        $icms->CST = '51';
        $icms->vBC = 100.0;
        $icms->modBC = 3;
        $icms->pDif = 40.5;

        $calculado = ICMS::calcularICMS($icms, '43', '43');

        $this->assertSame('0', $calculado->orig);
        $this->assertSame('51', $calculado->CST);
        $this->assertSame(3, $calculado->modBC);
        $this->assertSame(100.0, $calculado->vBC);
        $this->assertSame(17.0, $calculado->pICMS);
        $this->assertSame(10.12, $calculado->vICMS);
        $this->assertSame(17.0, $calculado->vICMSOp);
        $this->assertSame(40.5, $calculado->pDif);
        $this->assertSame(6.89, $calculado->vICMSDif);
    }

    /**
     * Test CST 51 with modBC !== 3
     * modBC === 0, modBC === 1 and modBC === 2 aren't implemented
     */
    public function testCST51ModBCDifferentThan3()
    {
        $this->expectException('\Exception');
        $icms = $this->instantiateICMS();
        $icms->orig = '0';
        $icms->CST = '51';
        $icms->modBC = 1;
        $icms->vBC = 1234.56;

        ICMS::calcularICMS($icms, '11', '11');
    }

    /**
     * Test CST 90
     */
    public function testCST90()
    {
        $icms = $this->instantiateICMS();
        $icms->orig = '0';
        $icms->CST = '90';
        $icms->modBC = 3;
        $icms->vBC = 152.0;
        $icms->motDesICMS = 9;

        $calculado = ICMS::calcularICMS($icms, '11', '11');

        $this->assertSame('0', $calculado->orig);
        $this->assertSame('90', $calculado->CST);
        $this->assertSame(3, $calculado->modBC);
        $this->assertSame(152.0, $calculado->vBC);
        $this->assertSame(17.5, $calculado->pICMS);
        $this->assertSame(26.6, $calculado->vICMS);
    }

    /**
     * Test CST 101
     */
    public function testCST101()
    {
        $icms = $this->instantiateICMS();
        $icms->orig = '0';
        $icms->CST = '101';
        $icms->vBC = 138.30;
        $icms->pCredSN = 2.56;

        $calculado = ICMS::calcularICMS($icms);

        $this->assertSame('0', $calculado->orig);
        $this->assertSame('101', $calculado->CST);
        $this->assertSame(2.56, $calculado->pCredSN);
        $this->assertSame(3.54, $calculado->vCredICMSSN);
    }

    /**
     * Test CST 102
     */
    public function testCST102()
    {
        $icms = $this->instantiateICMS();
        $icms->orig = '0';
        $icms->CST = '102';

        $calculado = ICMS::calcularICMS($icms);

        $this->assertSame('0', $calculado->orig);
        $this->assertSame('102', $calculado->CST);
    }

    /**
     * Test not implemented CST
     */
    public function testNotImplementedCST()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $this->expectExceptionMessage('CST 20 not implemented');
        $this->expectExceptionCode(0);
        $icms = $this->instantiateICMS();
        $icms->CST = '20';
        ICMS::calcularICMS($icms, '11', '11');
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
