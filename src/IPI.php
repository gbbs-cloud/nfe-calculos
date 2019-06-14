<?php

declare(strict_types=1);

namespace Gbbs\NfeCalculos;

use Exception;

class IPI
{
    public $descCST;
    public $clEnq;
    public $CNPJProd;
    public $cSelo;
    public $qSelo;
    public $cEnq;
    private $CST;
    public $vBC;
    public $pIPI;
    public $vIPI;
    public $qUnid;
    public $vUnid;
    public $CodNCM;
    public $REIDE;
    public $SUFRAMA;
    public $CSTNotaRef;
    public $Zerar;

    /**
     * @param $IPI
     * @param $pIPI
     * @return mixed
     * @throws Exception
     */
    public static function calcular(IPI $IPI, $pIPI)
    {
        $IPI->pIPI = $pIPI;

        if ($IPI->Zerar === 1) {
            $IPI->vBC = '0';
            if ($IPI->vIPI === 0) {
                $IPI->pIPI = 0;
            }
            return $IPI;
        }

        if ($IPI->getCST() === '00') {
            /* ENTRADA COM RECUPERAÇÃO DE CRÉDITO */
            return self::calcAliquotaAdValoren($IPI);
        } elseif ($IPI->getCST() === '49') {
            /* OUTRAS ENTRADAS */
            return self::calcRetornoIsentoValorOutros($IPI);
        } elseif ($IPI->getCST() === '50') {
            /* SAÍDA TRIBUTADA */
            return self::calcAliquotaAdValoren($IPI);
        } elseif ($IPI->getCST() === '99') {
            /* OUTRAS SAÍDAS */
            return self::calcAliquotaAdValoren($IPI);
        } elseif ($IPI->getCST() === '01') {
            /* 01 ENTRADA TRIBUTADA COM ALICOTA ZERO */
            return self::calcIsento($IPI);
        } elseif ($IPI->getCST() === '02') {
            /* ENTRADA ISENTA */
            return self::calcIsento($IPI);
        } elseif ($IPI->getCST() === '03') {
            /* ENTRADA NÃO TRIBUTADA */
            return self::calcIsento($IPI);
        } elseif ($IPI->getCST() === '04') {
            /* ENTRADA IMUNE */
            return self::calcIsento($IPI);
        } elseif ($IPI->getCST() === '05') {
            /* ENTRADA COM SUSPENSAO */
            return self::calcIsento($IPI);
        } elseif ($IPI->getCST() === '51') {
            /* SAÍDA TRIBUTADA COM ALICOTA ZERO */
            return self::calcIsento($IPI);
        } elseif ($IPI->getCST() === '52') {
            /* SAÍDA ISENTA */
            return self::calcIsento($IPI);
        } elseif ($IPI->getCST() === '53') {
            /* SAÍDA NÃO-TRIBUTADA */
            return self::calcIsento($IPI);
        } elseif ($IPI->getCST() === '54') {
            /* SAÍDA IMUNE */
            return self::calcIsento($IPI);
        } elseif ($IPI->getCST() === '55') {
            /* SAÍDA COM SUSPENSAO */
            return self::calcIsento($IPI);
        }
        throw new Exception('Erro ao calcular IPI' . print_r($IPI, true));
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

    /**
     * @return string
     */
    public function getCST(): string
    {
        return $this->CST;
    }

    /**
     * @param string $CST
     */
    public function setCST(string $CST): void
    {
        $this->CST = $CST;
    }
}
