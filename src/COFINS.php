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
}

/**
 * @param COFINS $COFINS
 * @return COFINS
 * @throws NotImplementedCSTException|InvalidCSTException
 */
function calcularCOFINS(COFINS $COFINS): COFINS
{
    $adValorem = ['01'];
    $notImplemented = [
        '02', '03', '04', '05', '06', '07', '08', '09', '49', '50', '51', '52', '53',
        '54', '55', '56', '60', '61', '62', '63', '64', '65', '66', '67', '70', '71',
        '72', '73', '74', '75', '98', '99'
    ];
    if (in_array($COFINS->CST, $adValorem, true)) {
        return adValoremCOFINS($COFINS);
    } elseif (in_array($COFINS->CST, $notImplemented, true)) {
        throw new NotImplementedCSTException($COFINS->CST);
    }
    throw new InvalidCSTException($COFINS->CST);
}

/**
 * @param COFINS $COFINS
 * @return COFINS
 */
function adValoremCOFINS(COFINS $COFINS): COFINS
{
    $pCOFINS = 3;
    $calculado = new COFINS();
    $calculado->CST = $COFINS->CST;
    $calculado->vBC = $COFINS->vBC;
    $calculado->pCOFINS = $pCOFINS;
    $calculado->vCOFINS = $COFINS->vBC * ($pCOFINS / 100);
    return $calculado;
}
