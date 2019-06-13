<?php

declare(strict_types=1);

namespace Gbbs\Impostos;

use Exception;

class COFINS
{
    /**
     * @param $COFINS
     * @param $CST
     * @return mixed
     * @throws Exception
     */
    public static function calcular($COFINS, $CST)
    {
        if ($COFINS->Zerar === 1) {
            $COFINS->pCOFINS = '0';
            $COFINS->vBC = '0';
            $COFINS->pCOFINS = '0';

            return $COFINS;
        }

        if (!($CST === null)) {
            $COFINS->CST = $CST;
        }
        switch ($COFINS->CST) {
            /* Operação Tributável com Alíquota Básica */
            case '01':
                return self::calcaCOFINS($COFINS);
                break;
            case '02':
                return self::calcaCOFINS($COFINS);
                break;
            case '03':
                return self::calcAliqCST03($COFINS);
                break;
            case '04':
                return self::calcIsento($COFINS);
                break;
            case '05':
                return self::calcIsento($COFINS);
                break;
            case '06':
                return self::calcIsento($COFINS);
                break;
            case '07':
                return self::calcIsentoDesconto($COFINS);
                break;
            case '08':
                return self::calcIsento($COFINS);
                break;
            case '09':
                return self::calcIsento($COFINS);
                break;
            case '49':
                return self::calcIsento($COFINS);
                break;
            case '50':
                return self::calcaCOFINS($COFINS);
                break;
            case '51':
                return self::calcaCOFINS($COFINS);
                break;
            case '52':
                return self::calcaCOFINS($COFINS);
                break;
            case '53':
                return self::calcaCOFINS($COFINS);
                break;
            case '54':
                return self::calcaCOFINS($COFINS);
                break;
            case '55':
                return self::calcaCOFINS($COFINS);
                break;
            case '56':
                return self::calcaCOFINS($COFINS);
                break;
            case '60':
                return self::calcaCOFINS($COFINS);
                break;
            case '61':
                return self::calcaCOFINS($COFINS);
                break;
            case '62':
                return self::calcaCOFINS($COFINS);
                break;
            case '63':
                return self::calcaCOFINS($COFINS);
                break;
            case '64':
                return self::calcaCOFINS($COFINS);
                break;
            case '65':
                return self::calcaCOFINS($COFINS);
                break;
            case '66':
                return self::calcaCOFINS($COFINS);
                break;
            case '67':
                return self::calcaCOFINS($COFINS);
                break;
            case '70':
                return self::calcIsento($COFINS);
                break;
            case '71':
                return self::calcaCOFINS($COFINS);
                break;
            case '72':
                return self::calcaCOFINS($COFINS);
                break;
            case '73':
                return self::calcaCOFINS($COFINS);
                break;
            case '74':
                return self::calcaCOFINS($COFINS);
                break;
            case '75':
                return self::calcaCOFINS($COFINS);
                break;
            case '98':
                return self::calcaCOFINS($COFINS);
                break;
            case '99':
                return self::calcIsento($COFINS);
                break;
        }
        throw new Exception();
    }

    private static function calcIsento($COFINS)
    {
        $COFINS->pCOFINS = 3;
        if ($COFINS->REIDE === 1 || $COFINS->SUFRAMA === 1) {
            $COFINS->Desconto = $COFINS->vBC * ($COFINS->pCOFINS / 100);
        } else {
            $COFINS->Desconto = 0;
        }
        $COFINS->vCOFINS = '0';
        $COFINS->vBC = '0';
        $COFINS->pCOFINS = '0';

        return $COFINS;
    }

    private static function calcaCOFINS($COFINS)
    {
        $COFINS->pCOFINS = 3;
        $COFINS->pRedBC = 0;
        $COFINS->vCOFINS = (($COFINS->vBC - ($COFINS->vBC * ($COFINS->pRedBC / 100))) * ($COFINS->pCOFINS / 100));
        if ($COFINS->REIDE === 1 || $COFINS->SUFRAMA === 1) {
            $COFINS->Desconto = $COFINS->vBC * ($COFINS->pCOFINS / 100);
        } else {
            $COFINS->Desconto = 0;
        }
        return $COFINS;
    }

    private static function calcIsentoDesconto($COFINS)
    {
        $COFINS->pCOFINS = 3;
        if ($COFINS->REIDE === 1 || $COFINS->SUFRAMA === 1) {
            $COFINS->Desconto = $COFINS->vBC * ($COFINS->pCOFINS / 100);
        } else {
            $COFINS->Desconto = 0;
        }

        $COFINS->pCOFINS = '0';
        $COFINS->vBC = '0';
        $COFINS->pCOFINS = '0';
        $COFINS->vCOFINS = '0';

        return $COFINS;
    }

    private static function calcAliqCST03($COFINS)
    {
        $COFINS->vBC = 0;
        $COFINS->pCOFINS = 0;
        $COFINS->vCOFINS = round((($COFINS->vAliqProd) * ($COFINS->qBCProd)), 2);
        $COFINS->Desconto = 0;

        return $COFINS;
    }
}
