<?php

declare(strict_types=1);

namespace Gbbs\Impostos;

use Exception;

class PIS
{
    /**
     * @param $PIS
     * @param $CST
     * @return mixed
     * @throws Exception
     */
    public static function calcular($PIS, $CST)
    {
        if ($PIS->Zerar === 1) {
            $PIS->pPIS = '0';
            $PIS->vBC = '0';
            $PIS->pPIS = '0';

            return $PIS;
        }

        if (!($CST === null)) {
            $PIS->CST = $CST;
        }
        switch ($PIS->CST) {
            /* Operação Tributável com Alíquota Básica */
            case '01':
                return self::calcaPIS($PIS);
                break;
            case '02':
                return self::calcaPIS($PIS);
                break;
            case '03':
                return self::calcAliqCST03($PIS);
                break;
            case '04':
                return self::calcIsento($PIS);
                break;
            case '05':
                return self::calcIsento($PIS);
                break;
            case '06':
                return self::calcIsento($PIS);
                break;
            case '07':
                return self::calcIsentoDesconto($PIS);
                break;
            case '08':
                return self::calcIsento($PIS);
                break;
            case '09':
                return self::calcIsento($PIS);
                break;
            case '49':
                return self::calcIsento($PIS);
                break;
            case '50':
                return self::calcaPIS($PIS);
                break;
            case '51':
                return self::calcaPIS($PIS);
                break;
            case '52':
                return self::calcaPIS($PIS);
                break;
            case '53':
                return self::calcaPIS($PIS);
                break;
            case '54':
                return self::calcaPIS($PIS);
                break;
            case '55':
                return self::calcaPIS($PIS);
                break;
            case '56':
                return self::calcaPIS($PIS);
                break;
            case '60':
                return self::calcaPIS($PIS);
                break;
            case '61':
                return self::calcaPIS($PIS);
                break;
            case '62':
                return self::calcaPIS($PIS);
                break;
            case '63':
                return self::calcaPIS($PIS);
                break;
            case '64':
                return self::calcaPIS($PIS);
                break;
            case '65':
                return self::calcaPIS($PIS);
                break;
            case '66':
                return self::calcaPIS($PIS);
                break;
            case '67':
                return self::calcaPIS($PIS);
                break;
            case '70':
                return self::calcIsento($PIS);
                break;
            case '71':
                return self::calcaPIS($PIS);
                break;
            case '72':
                return self::calcaPIS($PIS);
                break;
            case '73':
                return self::calcaPIS($PIS);
                break;
            case '74':
                return self::calcaPIS($PIS);
                break;
            case '75':
                return self::calcaPIS($PIS);
                break;
            case '98':
                return self::calcaPIS($PIS);
                break;
            case '99':
                return self::calcIsento($PIS);
                break;
            default:
                break;
        }
        throw new Exception();
    }

    private static function calcIsento($PIS)
    {
        $PIS->pPIS = 0.65;
        if ($PIS->REIDE === 1 || $PIS->SUFRAMA === 1) {
            $PIS->Desconto = $PIS->vBC * ($PIS->pPIS / 100);
        } else {
            $PIS->Desconto = 0;
        }
        $PIS->vPIS = '0';
        $PIS->vBC = '0';
        $PIS->pPIS = '0';

        return $PIS;
    }

    private static function calcaPIS($PIS)
    {
        $PIS->pPIS = 0.65;
        if ($PIS->REIDE === 1 || $PIS->SUFRAMA === 1) {
            $PIS->Desconto = $PIS->vBC * ($PIS->pPIS / 100);
        } else {
            $PIS->Desconto = 0;
        }
        $PIS->pRedBC = 0;
        $PIS->vPIS = (($PIS->vBC - ($PIS->vBC * ($PIS->pRedBC / 100))) * ($PIS->pPIS / 100));
        return $PIS;
    }

    private static function calcIsentoDesconto($PIS)
    {
        $PIS->pPIS = 0.65;
        if ($PIS->REIDE === 1 || $PIS->SUFRAMA === 1) {
            $PIS->Desconto = $PIS->vBC * ($PIS->pPIS / 100);
        } else {
            $PIS->Desconto = 0;
        }
        $PIS->vPIS = '0';
        $PIS->vBC = '0';
        $PIS->pPIS = '0';
        $PIS->vPIS = '0';

        return $PIS;
    }

    private static function calcAliqCST03($PIS)
    {
        $PIS->vBC = 0;
        $PIS->pPIS = 0;
        $PIS->vPIS = round((($PIS->vAliqProd) * ($PIS->qBCProd)), 2);
        return $PIS;
    }
}
