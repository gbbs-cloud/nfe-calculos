<?php

declare(strict_types=1);

namespace Gbbs\NfeCalculos\Tests;

use Gbbs\NfeCalculos\PIS;
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
        $this->expectExceptionMessage('CST 00000 invalid');
        $this->expectExceptionCode(0);
        $pis = $this->instantiatePIS();
        $pis->CST = '00000';

        PIS::calcularPIS($pis, false);
    }

    /**
     * Test CST with adValoremPIS
     */
    public function testAdValoremPIS()
    {
        $pis = $this->instantiatePIS();
        $pis->CST = '01';
        $pis->vBC = 1234.56;

        $calculado = PIS::calcularPIS($pis, false);

        $this->assertSame('01', $calculado->CST);
        $this->assertSame(1234.56, $calculado->vBC);
        $this->assertSame(0.65, $calculado->pPIS);
        $this->assertSame(8.02, $calculado->vPIS);
    }

    /**
     * Test CST with zeradoPIS
     */
    public function testZeradoPIS()
    {
        $pis = $this->instantiatePIS();
        $pis->CST = '08';

        $calculado = PIS::calcularPIS($pis, false);

        $this->assertSame('08', $calculado->CST);
    }

    /**
     * Test CST with isentoPIS
     */
    public function testIsentoPIS()
    {
        $pis = $this->instantiatePIS();
        $pis->CST = '99';

        $calculado = PIS::calcularPIS($pis, false);

        $this->assertSame('99', $calculado->CST);
        $this->assertSame(0.0, $calculado->vBC);
        $this->assertSame(0.0, $calculado->pPIS);
        $this->assertSame(0.0, $calculado->vPIS);
    }

    /**
     * Test not implemented CST
     */
    public function testNotImplementedCST()
    {
        $this->expectException('\Gbbs\NfeCalculos\Exception\NotImplementedCSTException');
        $this->expectExceptionMessage('CST 03 not implemented');
        $this->expectExceptionCode(0);
        $pis = $this->instantiatePIS();
        $pis->CST = '03';

        PIS::calcularPIS($pis, false);
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
