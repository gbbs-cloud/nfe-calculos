<?php

declare(strict_types=1);

namespace Gbbs\NfeCalculos;

use Exception;

class PIS
{
    private $CST;
    public $vBC;
    public $pPIS;
    public $vPIS;
    public $pRedBC;
    public $Desconto;
    public $vAliqProd;
    public $qBCProd;
    public $REIDE;
    public $SUFRAMA;
    public $Zerar;

    /**
     * @param PIS $PIS
     * @return PIS|mixed
     * @throws Exception
     */
    public static function calcular(PIS $PIS)
    {
        if ($PIS->Zerar === 1) {
            $PIS->pPIS = '0';
            $PIS->vBC = '0';
            $PIS->pPIS = '0';

            return $PIS;
        }

        if ($PIS->getCST() === '01') {
            /* Operação Tributável com Alíquota Básica */
            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '02') {
            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '03') {
            return self::calcAliqCST03($PIS);
        } elseif ($PIS->getCST() === '04') {
            return self::calcIsento($PIS);
        } elseif ($PIS->getCST() === '05') {
            return self::calcIsento($PIS);
        } elseif ($PIS->getCST() === '06') {
            return self::calcIsento($PIS);
        } elseif ($PIS->getCST() === '07') {
            return self::calcIsentoDesconto($PIS);
        } elseif ($PIS->getCST() === '08') {
            return self::calcIsento($PIS);
        } elseif ($PIS->getCST() === '09') {
            return self::calcIsento($PIS);
        } elseif ($PIS->getCST() === '49') {
            return self::calcIsento($PIS);
        } elseif ($PIS->getCST() === '50') {
            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '51') {
            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '52') {
            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '53') {
            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '54') {
            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '55') {
            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '56') {
            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '60') {
            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '61') {
            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '62') {
            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '63') {
            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '64') {
            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '65') {
            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '66') {
            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '67') {
            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '70') {
            return self::calcIsento($PIS);
        } elseif ($PIS->getCST() === '71') {
            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '72') {
            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '73') {
            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '74') {
            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '75') {
            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '98') {
            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '99') {
            return self::calcIsento($PIS);
        }
        throw new Exception('Erro ao calcular PIS' . print_r($PIS, true));
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
