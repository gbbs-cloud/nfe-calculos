<?php

declare(strict_types=1);

namespace Gbbs\NfeCalculos;

use PHPUnit\Framework\TestCase;

class COFINSTest extends TestCase
{
    /**
     * @expectedException \TypeError
     */
    public function testFailingNullArgument()
    {
        COFINS::calcular(null);
    }

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
     * @expectedException \Exception
     */
    public function testInvalidCST()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('00000');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 01
     * @expectedException \Exception
     */
    public function testCST01()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('01');

        COFINS::calcular($cofins);

        $this->assertSame('01', $cofins->getCST());
        $this->assertSame(true, false);
    }

    /**
     * Test CST 02
     * @expectedException \Exception
     */
    public function testCST02()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('02');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 03
     * @expectedException \Exception
     */
    public function testCST03()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('03');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 04
     * @expectedException \Exception
     */
    public function testCST04()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('04');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 05
     * @expectedException \Exception
     */
    public function testCST05()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('05');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 06
     * @expectedException \Exception
     */
    public function testCST06()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('06');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 07
     * @expectedException \Exception
     */
    public function testCST07()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('07');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 08
     * @expectedException \Exception
     */
    public function testCST08()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('08');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 09
     * @expectedException \Exception
     */
    public function testCST09()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('09');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 49
     * @expectedException \Exception
     */
    public function testCST49()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('49');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 50
     * @expectedException \Exception
     */
    public function testCST50()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('50');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 51
     * @expectedException \Exception
     */
    public function testCST51()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('51');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 52
     * @expectedException \Exception
     */
    public function testCST52()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('52');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 53
     * @expectedException \Exception
     */
    public function testCST53()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('53');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 54
     * @expectedException \Exception
     */
    public function testCST54()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('54');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 55
     * @expectedException \Exception
     */
    public function testCST55()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('55');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 56
     * @expectedException \Exception
     */
    public function testCST56()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('56');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 60
     * @expectedException \Exception
     */
    public function testCST60()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('60');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 61
     * @expectedException \Exception
     */
    public function testCST61()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('61');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 62
     * @expectedException \Exception
     */
    public function testCST62()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('62');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 63
     * @expectedException \Exception
     */
    public function testCST63()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('63');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 64
     * @expectedException \Exception
     */
    public function testCST64()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('64');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 65
     * @expectedException \Exception
     */
    public function testCST65()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('65');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 66
     * @expectedException \Exception
     */
    public function testCST66()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('66');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 67
     * @expectedException \Exception
     */
    public function testCST67()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('67');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 70
     * @expectedException \Exception
     */
    public function testCST70()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('70');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 71
     * @expectedException \Exception
     */
    public function testCST71()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('71');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 72
     * @expectedException \Exception
     */
    public function testCST72()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('72');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 73
     * @expectedException \Exception
     */
    public function testCST73()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('73');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 74
     * @expectedException \Exception
     */
    public function testCST74()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('74');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 75
     * @expectedException \Exception
     */
    public function testCST75()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('75');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 98
     * @expectedException \Exception
     */
    public function testCST98()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('98');

        COFINS::calcular($cofins);
    }

    /**
     * Test CST 99
     * @expectedException \Exception
     */
    public function testCST99()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->setCST('99');

        COFINS::calcular($cofins);
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
