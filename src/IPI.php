<?php

declare(strict_types=1);

namespace Gbbs\NfeCalculos;

use Exception;
use Gbbs\NfeCalculos\Exception\InvalidCSTException;
use Gbbs\NfeCalculos\Exception\NotImplementedCSTException;

class IPI
{
    public $CNPJProd;
    public $cSelo;
    public $qSelo;
    public $cEnq;
    public $CST;
    public $vBC;
    public $pIPI;
    public $vIPI;
    public $qUnid;
    public $vUnid;
}

/**
 * @param IPI $IPI
 * @return IPI
 * @throws NotImplementedCSTException|InvalidCSTException
 */
function calcularIPI(IPI $IPI): IPI
{
    $adValorem = ['50'];
    $isento = ['51'];
    $notImplemented = [
        '00', '01', '02', '03', '04', '05', '49', '52', '53', '54', '55', '99'
    ];
    if (in_array($IPI->CST, $adValorem, true)) {
        return adValoremIPI($IPI);
    } elseif (in_array($IPI->CST, $isento, true)) {
        return calcIsentoIPI($IPI);
    } elseif (in_array($IPI->CST, $notImplemented, true)) {
        throw new NotImplementedCSTException($IPI->CST);
    }
    throw new InvalidCSTException($IPI->CST);
}

/**
 * ISENTO
 * @param IPI $IPI
 * @return IPI
 */
function calcIsentoIPI(IPI $IPI): IPI
{
    $calculado = new IPI();
    $calculado->CST = $IPI->CST;
    $calculado->vBC = 0.0;
    $calculado->pIPI = 0.0;
    $calculado->vIPI = 0.0;
    return $calculado;
}

/**
 * Calcula o Valor IPI Ad Valoren
 * @param IPI $IPI
 * @return IPI
 */
function adValoremIPI(IPI $IPI): IPI
{
    $calculado = new IPI();
    $calculado->CST = $IPI->CST;
    $calculado->vBC = $IPI->vBC;
    $calculado->vIPI = $IPI->vBC * ($IPI->pIPI / 100);
    $calculado->pIPI = $IPI->pIPI;
    return $calculado;
}

/**
 * @param string $ncm
 * @return float
 * @throws Exception
 */
function pIPIFromNCM(string $ncm): float
{
    $path = realpath(__DIR__ . '/../storage') . '/';
    $tipiFile = file_get_contents($path . 'tipi.json');
    $tipiList = json_decode($tipiFile, true);
    foreach ($tipiList as $tipi) {
        if ($tipi['NCMNum'] === $ncm) {
            return (float) ($tipi['NCMAli'] === 'NT'? 0 : $tipi['NCMAli']);
        }
    }
    throw new Exception('NCM inexistente: ' . $ncm);
}
