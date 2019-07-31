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

    /**
     * @param PIS $PIS
     * @return PIS|mixed
     * @throws NotImplementedCSTException|InvalidCSTException
     */
    public static function calcular(PIS $PIS)
    {
        /* Operação Tributável com Alíquota Básica */
        if ($PIS->getCST() === '01') {
            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '02') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '03') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcAliqCST03($PIS);
        } elseif ($PIS->getCST() === '04') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcIsento($PIS);
        } elseif ($PIS->getCST() === '05') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcIsento($PIS);
        } elseif ($PIS->getCST() === '06') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcIsento($PIS);
        } elseif ($PIS->getCST() === '07') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcIsentoDesconto($PIS);
        } elseif ($PIS->getCST() === '08') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcIsento($PIS);
        } elseif ($PIS->getCST() === '09') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcIsento($PIS);
        } elseif ($PIS->getCST() === '49') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcIsento($PIS);
        } elseif ($PIS->getCST() === '50') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '51') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '52') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '53') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '54') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '55') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '56') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '60') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '61') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '62') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '63') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '64') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '65') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '66') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '67') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '70') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcIsento($PIS);
        } elseif ($PIS->getCST() === '71') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '72') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '73') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '74') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '75') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '98') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcaPIS($PIS);
        } elseif ($PIS->getCST() === '99') {
            throw new NotImplementedCSTException($PIS->getCST());
//            return self::calcIsento($PIS);
        }
        throw new InvalidCSTException($PIS->getCST());
    }

//    private static function calcIsento($PIS)
//    {
//        $PIS->pPIS = 0.65;
//        if ($PIS->REIDI === 1 || $PIS->SUFRAMA === 1) {
//            $PIS->Desconto = $PIS->vBC * ($PIS->pPIS / 100);
//        } else {
//            $PIS->Desconto = 0;
//        }
//        $PIS->vPIS = '0';
//        $PIS->vBC = '0';
//        $PIS->pPIS = '0';
//
//        return $PIS;
//    }

    private static function calcaPIS($PIS)
    {
        $PIS->pPIS = 0.65;
//        if ($PIS->REIDI === 1 || $PIS->SUFRAMA === 1) {
//            $PIS->Desconto = $PIS->vBC * ($PIS->pPIS / 100);
//        } else {
        $PIS->Desconto = 0;
//        }
        $PIS->pRedBC = 0;
        $PIS->vPIS = (($PIS->vBC - ($PIS->vBC * ($PIS->pRedBC / 100))) * ($PIS->pPIS / 100));
        return $PIS;
    }

//    private static function calcIsentoDesconto($PIS)
//    {
//        $PIS->pPIS = 0.65;
//        if ($PIS->REIDI === 1 || $PIS->SUFRAMA === 1) {
//            $PIS->Desconto = $PIS->vBC * ($PIS->pPIS / 100);
//        } else {
//            $PIS->Desconto = 0;
//        }
//        $PIS->vPIS = '0';
//        $PIS->vBC = '0';
//        $PIS->pPIS = '0';
//        $PIS->vPIS = '0';
//
//        return $PIS;
//    }
//
//    private static function calcAliqCST03($PIS)
//    {
//        $PIS->vBC = 0;
//        $PIS->pPIS = 0;
//        $PIS->vPIS = round((($PIS->vAliqProd) * ($PIS->qBCProd)), 2);
//        return $PIS;
//    }

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
