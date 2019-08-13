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
     * Test CST with adValorem
     */
    public function testAdValorem()
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
     * Test CST not implemented
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
