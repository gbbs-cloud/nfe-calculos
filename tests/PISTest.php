<?php

declare(strict_types=1);

namespace Gbbs\NfeCalculos;

use PHPUnit\Framework\TestCase;

class PISTest extends TestCase
{
    /**
     * @expectedException \TypeError
     */
    public function testFailingNullArgument()
    {
        PIS::calcular(null);
    }

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
     * @expectedException \Gbbs\NfeCalculos\Exception\InvalidCSTException
     */
    public function testInvalidCST()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('00000');

        PIS::calcular($pis);
    }

    /**
     * Test CST 01
     */
    public function testCST01()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('01');

        PIS::calcular($pis);

        $this->assertSame('01', $pis->getCST());
    }

    /**
     * Test CST 02
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST02()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('02');

        PIS::calcular($pis);
    }

    /**
     * Test CST 03
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST03()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('03');

        PIS::calcular($pis);
    }

    /**
     * Test CST 04
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST04()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('04');

        PIS::calcular($pis);
    }

    /**
     * Test CST 05
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST05()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('05');

        PIS::calcular($pis);
    }

    /**
     * Test CST 06
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST06()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('06');

        PIS::calcular($pis);
    }

    /**
     * Test CST 07
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST07()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('07');

        PIS::calcular($pis);
    }

    /**
     * Test CST 08
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST08()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('08');

        PIS::calcular($pis);
    }

    /**
     * Test CST 09
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST09()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('09');

        PIS::calcular($pis);
    }

    /**
     * Test CST 49
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST49()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('49');

        PIS::calcular($pis);
    }

    /**
     * Test CST 50
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST50()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('50');

        PIS::calcular($pis);
    }

    /**
     * Test CST 51
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST51()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('51');

        PIS::calcular($pis);
    }

    /**
     * Test CST 52
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST52()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('52');

        PIS::calcular($pis);
    }

    /**
     * Test CST 53
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST53()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('53');

        PIS::calcular($pis);
    }

    /**
     * Test CST 54
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST54()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('54');

        PIS::calcular($pis);
    }

    /**
     * Test CST 55
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST55()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('55');

        PIS::calcular($pis);
    }

    /**
     * Test CST 56
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST56()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('56');

        PIS::calcular($pis);
    }

    /**
     * Test CST 60
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST60()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('60');

        PIS::calcular($pis);
    }

    /**
     * Test CST 61
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST61()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('61');

        PIS::calcular($pis);
    }

    /**
     * Test CST 62
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST62()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('62');

        PIS::calcular($pis);
    }

    /**
     * Test CST 63
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST63()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('63');

        PIS::calcular($pis);
    }

    /**
     * Test CST 64
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST64()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('64');

        PIS::calcular($pis);
    }

    /**
     * Test CST 65
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST65()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('65');

        PIS::calcular($pis);
    }

    /**
     * Test CST 66
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST66()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('66');

        PIS::calcular($pis);
    }

    /**
     * Test CST 67
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST67()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('67');

        PIS::calcular($pis);
    }

    /**
     * Test CST 70
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST70()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('70');

        PIS::calcular($pis);
    }

    /**
     * Test CST 71
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST71()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('71');

        PIS::calcular($pis);
    }

    /**
     * Test CST 72
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST72()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('72');

        PIS::calcular($pis);
    }

    /**
     * Test CST 73
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST73()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('73');

        PIS::calcular($pis);
    }

    /**
     * Test CST 74
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST74()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('74');

        PIS::calcular($pis);
    }

    /**
     * Test CST 75
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST75()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('75');

        PIS::calcular($pis);
    }

    /**
     * Test CST 98
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST98()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('98');

        PIS::calcular($pis);
    }

    /**
     * Test CST 99
     * @expectedException \Gbbs\NfeCalculos\Exception\NotImplementedCSTException
     */
    public function testCST99()
    {
        $pis = $this->instantiatePIS();
        $pis->setCST('99');

        PIS::calcular($pis);
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
