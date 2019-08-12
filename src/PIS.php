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
    /* Operação Tributável com Alíquota Básica */
    if ($PIS->CST === '01') {
        return adValoremPIS($PIS);
    } elseif ($PIS->CST === '02') {
        throw new NotImplementedCSTException($PIS->CST);
    } elseif ($PIS->CST === '03') {
        throw new NotImplementedCSTException($PIS->CST);
    } elseif ($PIS->CST === '04') {
        throw new NotImplementedCSTException($PIS->CST);
    } elseif ($PIS->CST === '05') {
        throw new NotImplementedCSTException($PIS->CST);
    } elseif ($PIS->CST === '06') {
        throw new NotImplementedCSTException($PIS->CST);
    } elseif ($PIS->CST === '07') {
        throw new NotImplementedCSTException($PIS->CST);
    } elseif ($PIS->CST === '08') {
        throw new NotImplementedCSTException($PIS->CST);
    } elseif ($PIS->CST === '09') {
        throw new NotImplementedCSTException($PIS->CST);
    } elseif ($PIS->CST === '49') {
        throw new NotImplementedCSTException($PIS->CST);
    } elseif ($PIS->CST === '50') {
        throw new NotImplementedCSTException($PIS->CST);
    } elseif ($PIS->CST === '51') {
        throw new NotImplementedCSTException($PIS->CST);
    } elseif ($PIS->CST === '52') {
        throw new NotImplementedCSTException($PIS->CST);
    } elseif ($PIS->CST === '53') {
        throw new NotImplementedCSTException($PIS->CST);
    } elseif ($PIS->CST === '54') {
        throw new NotImplementedCSTException($PIS->CST);
    } elseif ($PIS->CST === '55') {
        throw new NotImplementedCSTException($PIS->CST);
    } elseif ($PIS->CST === '56') {
        throw new NotImplementedCSTException($PIS->CST);
    } elseif ($PIS->CST === '60') {
        throw new NotImplementedCSTException($PIS->CST);
    } elseif ($PIS->CST === '61') {
        throw new NotImplementedCSTException($PIS->CST);
    } elseif ($PIS->CST === '62') {
        throw new NotImplementedCSTException($PIS->CST);
    } elseif ($PIS->CST === '63') {
        throw new NotImplementedCSTException($PIS->CST);
    } elseif ($PIS->CST === '64') {
        throw new NotImplementedCSTException($PIS->CST);
    } elseif ($PIS->CST === '65') {
        throw new NotImplementedCSTException($PIS->CST);
    } elseif ($PIS->CST === '66') {
        throw new NotImplementedCSTException($PIS->CST);
    } elseif ($PIS->CST === '67') {
        throw new NotImplementedCSTException($PIS->CST);
    } elseif ($PIS->CST === '70') {
        throw new NotImplementedCSTException($PIS->CST);
    } elseif ($PIS->CST === '71') {
        throw new NotImplementedCSTException($PIS->CST);
    } elseif ($PIS->CST === '72') {
        throw new NotImplementedCSTException($PIS->CST);
    } elseif ($PIS->CST === '73') {
        throw new NotImplementedCSTException($PIS->CST);
    } elseif ($PIS->CST === '74') {
        throw new NotImplementedCSTException($PIS->CST);
    } elseif ($PIS->CST === '75') {
        throw new NotImplementedCSTException($PIS->CST);
    } elseif ($PIS->CST === '98') {
        throw new NotImplementedCSTException($PIS->CST);
    } elseif ($PIS->CST === '99') {
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
