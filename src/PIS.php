<?php

declare(strict_types=1);

namespace Gbbs\NfeCalculos;

use Gbbs\NfeCalculos\Exception\InvalidCSTException;
use Gbbs\NfeCalculos\Exception\NotImplementedCSTException;

class PIS
{
    public $CST;
    public $vBC;
    public $pPIS;
    public $vPIS;
    public $qBCProd;
    public $vAliqProd;
}

/**
 * @param PIS $PIS
 * @return PIS
 * @throws NotImplementedCSTException|InvalidCSTException
 */
function calcularPIS(PIS $PIS)
{
    $adValorem = ['01'];
    $notImplemented = [
        '02', '03', '04', '05', '06', '07', '08', '09', '49', '50', '51', '52', '53',
        '54', '55', '56', '60', '61', '62', '63', '64', '65', '66', '67', '70', '71',
        '72', '73', '74', '75', '98', '99'
    ];

    if (in_array($PIS->CST, $adValorem, true)) {
        return adValoremPIS($PIS);
    } elseif (in_array($PIS->CST, $notImplemented, true)) {
        throw new NotImplementedCSTException($PIS->CST);
    }
    throw new InvalidCSTException($PIS->CST);
}

/**
 * @param PIS $PIS
 * @return PIS
 */
function adValoremPIS(PIS $PIS)
{
    $pPIS = 0.65;
    $calculado = new PIS();
    $calculado->CST = $PIS->CST;
    $calculado->vBC = $PIS->vBC;
    $calculado->pPIS = $pPIS;
    $calculado->vPIS = $PIS->vBC * ($pPIS / 100);
    return $calculado;
}
