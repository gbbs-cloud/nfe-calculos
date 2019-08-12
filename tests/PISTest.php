<?php

declare(strict_types=1);

namespace Gbbs\NfeCalculos;

use PHPUnit\Framework\TestCase;

class PISTest extends TestCase
{
    /**
     * Test that object is Instance of PIS
     */
    public function testIsInstancePIS()
    {
        $pis = $this->instantiatePIS();
        $this->assertInstanceOf(PIS::class, $pis);
    }

    /**
     * Test invalid CST
     */
    public function testInvalidCST()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\InvalidCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '00000';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 01
     */
    public function testCST01()
    {
        $pis = $this->instantiatePIS();
        $pis->CST = '01';
        $pis->vBC = 1000;

        $calculado = calcularPIS($pis);

        $this->assertSame('01', $calculado->CST);
        $this->assertSame(1000, $calculado->vBC);
        $this->assertSame(0.65, $calculado->pPIS);
        $this->assertSame(6.5, $calculado->vPIS);
    }

    /**
     * Test CST 02
     */
    public function testCST02()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '02';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 03
     */
    public function testCST03()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '03';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 04
     */
    public function testCST04()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '04';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 05
     */
    public function testCST05()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '05';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 06
     */
    public function testCST06()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '06';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 07
     */
    public function testCST07()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '07';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 08
     */
    public function testCST08()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '08';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 09
     */
    public function testCST09()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '09';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 49
     */
    public function testCST49()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '49';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 50
     */
    public function testCST50()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '50';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 51
     */
    public function testCST51()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '51';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 52
     */
    public function testCST52()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '52';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 53
     */
    public function testCST53()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '53';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 54
     */
    public function testCST54()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '54';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 55
     */
    public function testCST55()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '55';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 56
     */
    public function testCST56()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '56';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 60
     */
    public function testCST60()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '60';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 61
     */
    public function testCST61()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '61';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 62
     */
    public function testCST62()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '62';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 63
     */
    public function testCST63()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '63';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 64
     */
    public function testCST64()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '64';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 65
     */
    public function testCST65()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '65';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 66
     */
    public function testCST66()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '66';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 67
     */
    public function testCST67()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '67';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 70
     */
    public function testCST70()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '70';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 71
     */
    public function testCST71()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '71';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 72
     */
    public function testCST72()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '72';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 73
     */
    public function testCST73()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '73';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 74
     */
    public function testCST74()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '74';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 75
     */
    public function testCST75()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '75';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 98
     */
    public function testCST98()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '98';

        $calculado = calcularPIS($pis);
    }

    /**
     * Test CST 99
     */
    public function testCST99()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '99';

        $calculado = calcularPIS($pis);
    }

    /**
     * Instantiate and return an PIS object
     */
    private function instantiatePIS()
    {
        $pis = new PIS();
        return $pis;
    }
}
