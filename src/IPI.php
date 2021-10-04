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

    /**
     * @param IPI $IPI
     * @return IPI
     * @throws NotImplementedCSTException|InvalidCSTException
     */
    static function calcularIPI(IPI $IPI): IPI
    {
        $adValorem = ['00', '50'];
        $isento = ['01', '03', '04', '51', '53', '54', '55', '99'];
        $notImplemented = ['02', '05', '49', '52'];
        if (in_array($IPI->CST, $adValorem, true)) {
            return IPI::adValoremIPI($IPI);
        }
        if (in_array($IPI->CST, $isento, true)) {
            return IPI::isentoIPI($IPI);
        }
        if (in_array($IPI->CST, $notImplemented, true)) {
            throw new NotImplementedCSTException($IPI->CST);
        }
        throw new InvalidCSTException($IPI->CST);
    }

    /**
     * ISENTO
     * @param IPI $IPI
     * @return IPI
     */
    private static function isentoIPI(IPI $IPI): IPI
    {
        $calculado = new IPI();
        $calculado->cEnq = $IPI->cEnq;
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
    private static function adValoremIPI(IPI $IPI): IPI
    {
        $calculado = new IPI();
        $calculado->cEnq = $IPI->cEnq;
        $calculado->CST = $IPI->CST;
        $calculado->vBC = $IPI->vBC;
        $calculado->pIPI = $IPI->pIPI;
        $calculado->vIPI = $IPI->vBC * ($IPI->pIPI / 100);
        return $calculado;
    }

    /**
     * @param string $ncm
     * @return float
     * @throws Exception
     */
    public static function pIPIFromNCM(string $ncm): float
    {
        $path = realpath(__DIR__ . '/../storage') . '/';
        $tipiFile = file_get_contents($path . 'tipi.json');
        $tipiList = json_decode($tipiFile, true);
        foreach ($tipiList as $tipi) {
            if ($tipi['NCMNum'] === $ncm) {
                return (float) ($tipi['NCMAli'] === 'NT' ? 0 : $tipi['NCMAli']);
            }
        }
        throw new Exception('NCM inexistente: ' . $ncm);
    }
}
