<?php

declare(strict_types=1);

namespace Gbbs\NfeCalculos\Tests;

use Gbbs\NfeCalculos\COFINS;
use PHPUnit\Framework\TestCase;

use function Gbbs\NfeCalculos\calcularCOFINS;

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
     * Test CST with adValoremCOFINS
     */
    public function testAdValoremCOFINS()
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
    * Test CST with zeradoCOFINS
    */
    public function testZeradoCOFINS()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '08';

        $calculado = calcularCOFINS($cofins);

        $this->assertSame('08', $calculado->CST);
    }

    /**
     * Test CST with isentoCOFINS
     */
    public function testIsentoCOFINS()
    {
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '99';

        $calculado = calcularCOFINS($cofins);

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
        $cofins = $this->instantiateCOFINS();
        $cofins->CST = '03';

        calcularCOFINS($cofins);
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
