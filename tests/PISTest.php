<?php

declare(strict_types=1);

namespace Gbbs\NfeCalculos\Tests;

use Gbbs\NfeCalculos\PIS;
use PHPUnit\Framework\TestCase;

use function Gbbs\NfeCalculos\calcularPIS;

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
     * Test CST with adValorem
     */
    public function testAdValorem()
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
     * Test CST not implemented
     */
    public function testNotImplementedCST()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $pis = $this->instantiatePIS();
        $pis->CST = '03';

        calcularPIS($pis);
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
