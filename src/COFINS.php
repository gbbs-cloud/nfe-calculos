<?php

declare(strict_types=1);

namespace Gbbs\NfeCalculos;

use Gbbs\NfeCalculos\Exception\InvalidCSTException;
use Gbbs\NfeCalculos\Exception\NotImplementedCSTException;

class COFINS
{
    public $CST;
    public $vBC;
    public $pCOFINS;
    public $vCOFINS;
    public $qBCProd;
    public $vAliqProd;

    /**
     * @param COFINS $COFINS
     * @return COFINS
     * @throws NotImplementedCSTException|InvalidCSTException
     */
    static function calcularCOFINS(COFINS $COFINS): COFINS
    {
        $adValorem = [
            '01', '02', '49', '50', '51', '52', '53', '54', '55', '56', '60', '61', '62',
            '63', '64', '65', '66', '67', '70', '71', '72', '73', '74', '75', '98'
        ];
        $zerado = ['08'];
        $isento = ['99'];
        $notImplemented = ['03', '04', '05', '06', '07', '09'];
        if (in_array($COFINS->CST, $adValorem, true)) {
            return COFINS::adValoremCOFINS($COFINS);
        }
        if (in_array($COFINS->CST, $zerado, true)) {
            return COFINS::zeradoCOFINS($COFINS);
        }
        if (in_array($COFINS->CST, $isento, true)) {
            return COFINS::isentoCOFINS($COFINS);
        }
        if (in_array($COFINS->CST, $notImplemented, true)) {
            throw new NotImplementedCSTException($COFINS->CST);
        }
        throw new InvalidCSTException($COFINS->CST);
    }

    /**
     * @param COFINS $COFINS
     * @return COFINS
     */
    private static function adValoremCOFINS(COFINS $COFINS): COFINS
    {
        $pCOFINS = 3;
        $calculado = new COFINS();
        $calculado->CST = $COFINS->CST;
        $calculado->vBC = $COFINS->vBC;
        $calculado->pCOFINS = $pCOFINS;
        $calculado->vCOFINS = (float)number_format($COFINS->vBC * ($pCOFINS / 100), 2);
        return $calculado;
    }

    /**
     * @param COFINS $COFINS
     * @return COFINS
     */
    private static function isentoCOFINS($COFINS): COFINS
    {
        $calculado = new COFINS();
        $calculado->CST = $COFINS->CST;
        $calculado->vBC = 0.0;
        $calculado->pCOFINS = 0.0;
        $calculado->vCOFINS = 0.0;
        return $calculado;
    }

    /**
     * @param COFINS $COFINS
     * @return COFINS
     */
    private static function zeradoCOFINS($COFINS): COFINS
    {
        $calculado = new COFINS();
        $calculado->CST = $COFINS->CST;
        return $calculado;
    }
}
