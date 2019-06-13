<?php

declare(strict_types=1);

namespace Gbbs\NfeCalculos;

use Exception;

class IPI
{
    /**
     * @param $IPI
     * @param $pIPI
     * @param $CST
     * @param $descricao
     * @return mixed
     * @throws Exception
     */
    public static function calcular($IPI, $pIPI, $CST, $descricao)
    {
        $IPI->pIPI = $pIPI;

        if ($IPI->Zerar === 1) {
            $IPI->vBC = '0';
            if ($IPI->vIPI === 0) {
                $IPI->pIPI = 0;
            }

            return $IPI;
        }

        if (!($CST === null) && !($descricao === null)) {
            $IPI->CST = $CST;
            $IPI->descCST = $descricao;
        }

        switch ($IPI->CST) {
            /* ENTRADA COM RECUPERAÇÃO DE CRÉDITO */
            case 00:
                return self::calcAliquotaAdValoren($IPI);
                break;
            /* OUTRAS ENTRADAS */
            case 49:
                return self::calcRetornoIsentoValorOutros($IPI);
                break;
            /* SAÍDA TRIBUTADA */
            case 50:
                return self::calcAliquotaAdValoren($IPI);
                break;
            /* OUTRAS SAÍDAS */
            case 99:
                return self::calcAliquotaAdValoren($IPI);
                break;

            /* 01 ENTRADA TRIBUTADA COM ALICOTA ZERO */
            case 01:
                return self::calcIsento($IPI);
                break;
            /* ENTRADA ISENTA */
            case 02:
                return self::calcIsento($IPI);
                break;
            /* ENTRADA NÃO TRIBUTADA */
            case 03:
                return self::calcIsento($IPI);
                break;
            /* ENTRADA IMUNE */
            case 04:
                return self::calcIsento($IPI);
                break;
            /* ENTRADA COM SUSPENSAO */
            case 05:
                return self::calcIsento($IPI);
                break;
            /* SAÍDA TRIBUTADA COM ALICOTA ZERO */
            case 51:
                return self::calcIsento($IPI);
                break;
            /* SAÍDA ISENTA */
            case 52:
                return self::calcIsento($IPI);
                break;
            /* SAÍDA NÃO-TRIBUTADA */
            case 53:
                return self::calcIsento($IPI);
                break;
            /* SAÍDA IMUNE */
            case 54:
                return self::calcIsento($IPI);
                break;
            /* SAÍDA COM SUSPENSAO */
            case 55:
                return self::calcIsento($IPI);
                break;
        }
        throw new Exception();
    }

    /*
     * @ISENTO
     */
    private static function calcIsento($IPI)
    {
        $IPI->vIPI = '0';
        $IPI->vBC = '0';
        $IPI->pIPI = '0';
        $IPI->qUnid = null;
        $IPI->vUnid = null;
        return $IPI;
    }

    /*
     * @Calcula o Valor IPI Ad Valoren
     */
    private static function calcAliquotaAdValoren($IPI)
    {
        $IPI->vIPI = ($IPI->vBC * ($IPI->pIPI / 100));
        return $IPI;
    }

    private static function calcRetornoIsentoValorOutros($IPI)
    {
        if ($IPI->CSTNotaRef === '00' || $IPI->CSTNotaRef === '50' || $IPI->CSTNotaRef === '99') {
            $IPI->vIPI = ($IPI->vBC * ($IPI->pIPI / 100));
            $IPI->pIPI = 0;
            return $IPI;
        } else {
            return self::calcIsento($IPI);
        }
    }
}
