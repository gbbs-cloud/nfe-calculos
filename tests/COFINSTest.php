<?php

declare(strict_types=1);

namespace Gbbs\NfeCalculos\Tests;

use Gbbs\NfeCalculos\COFINS;
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
        $this->expectExceptionMessage('CST 00000 invalid');
        $this->expectExceptionCode(0);
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '00000';

        COFINS::calcularCOFINS($cofins, false);
    }

    /**
     * Test CST with adValoremCOFINS
     */
    public function testAdValoremCOFINS()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '01';
        $cofins->vBC = 1234.56;

        $calculado = COFINS::calcularCOFINS($cofins, false);

        $this->assertSame('01', $calculado->CST);
        $this->assertSame(1234.56, $calculado->vBC);
        $this->assertSame(3, $calculado->pCOFINS);
        $this->assertSame(37.04, $calculado->vCOFINS);
    }

    /**
     * Test CST with zeradoCOFINS
     */
    public function testZeradoCOFINS()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '08';

        $calculado = COFINS::calcularCOFINS($cofins, false);

        $this->assertSame('08', $calculado->CST);
    }

    /**
     * Test CST with isentoCOFINS
     */
    public function testIsentoCOFINS()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '99';

        $calculado = COFINS::calcularCOFINS($cofins, false);

        $this->assertSame('99', $calculado->CST);
        $this->assertSame(0.0, $calculado->vBC);
        $this->assertSame(0.0, $calculado->pCOFINS);
        $this->assertSame(0.0, $calculado->vCOFINS);
    }

    /**
     * Test not implemented CST
     */
    public function testNotImplementedCST()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $this->expectExceptionMessage('CST 03 not implemented');
        $this->expectExceptionCode(0);
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '03';

        COFINS::calcularCOFINS($cofins, false);
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
