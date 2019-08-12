<?php

declare(strict_types=1);

namespace Gbbs\NfeCalculos;

use PHPUnit\Framework\TestCase;

class COFINSTest extends TestCase
{
    /**
     * Test that object is Instance of COFINS
     */
    public function testIsInstanceCOFINS()
    {
        $cofins = $this->instantiateCOFINS();
        $this->assertInstanceOf(COFINS::class, $cofins);
    }

    /**
     * Test invalid CST
     */
    public function testInvalidCST()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\InvalidCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '00000';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 01
     */
    public function testCST01()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '01';
        $cofins->vBC = 1000;

        $calculado = calcularCOFINS($cofins);

        $this->assertSame('01', $calculado->CST);
        $this->assertSame(1000, $calculado->vBC);
        $this->assertSame(3, $calculado->pCOFINS);
        $this->assertSame(30.0, $calculado->vCOFINS);
    }

    /**
     * Test CST 02
     */
    public function testCST02()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '02';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 03
     */
    public function testCST03()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '03';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 04
     */
    public function testCST04()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '04';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 05
     */
    public function testCST05()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '05';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 06
     */
    public function testCST06()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '06';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 07
     */
    public function testCST07()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '07';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 08
     */
    public function testCST08()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '08';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 09
     */
    public function testCST09()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '09';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 49
     */
    public function testCST49()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '49';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 50
     */
    public function testCST50()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '50';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 51
     */
    public function testCST51()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '51';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 52
     */
    public function testCST52()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '52';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 53
     */
    public function testCST53()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '53';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 54
     */
    public function testCST54()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '54';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 55
     */
    public function testCST55()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '55';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 56
     */
    public function testCST56()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '56';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 60
     */
    public function testCST60()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '60';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 61
     */
    public function testCST61()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '61';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 62
     */
    public function testCST62()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '62';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 63
     */
    public function testCST63()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '63';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 64
     */
    public function testCST64()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '64';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 65
     */
    public function testCST65()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '65';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 66
     */
    public function testCST66()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '66';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 67
     */
    public function testCST67()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '67';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 70
     */
    public function testCST70()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '70';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 71
     */
    public function testCST71()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '71';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 72
     */
    public function testCST72()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '72';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 73
     */
    public function testCST73()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '73';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 74
     */
    public function testCST74()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '74';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 75
     */
    public function testCST75()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '75';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 98
     */
    public function testCST98()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '98';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Test CST 99
     */
    public function testCST99()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '99';

        $calculado = calcularCOFINS($cofins);
    }

    /**
     * Instantiate and return an COFINS object
     */
    private function instantiateCOFINS()
    {
        $cofins = new COFINS();
        return $cofins;
    }
}
