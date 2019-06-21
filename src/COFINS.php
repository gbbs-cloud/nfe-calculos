<?php

declare(strict_types=1);

namespace Gbbs\NfeCalculos;

use Gbbs\NfeCalculos\Exception\InvalidCSTException;
use Gbbs\NfeCalculos\Exception\NotImplementedCSTException;

class COFINS
{
    private $CST;
    public $vBC;
    public $pCOFINS;
    public $vCOFINS;
    public $pRedBC;
    public $vAliqProd;
    public $qBCProd;
    public $Desconto;
//    public $REIDI;
//    public $SUFRAMA;

    /**
     * @param $COFINS
     * @return mixed
     * @throws NotImplementedCSTException|InvalidCSTException
     */
    public static function calcular(COFINS $COFINS)
    {
        /* Operação Tributável com Alíquota Básica */
        if ($COFINS->getCST() === '01') {
            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '02') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '03') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcAliqCST03($COFINS);
        } elseif ($COFINS->getCST() === '04') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcIsento($COFINS);
        } elseif ($COFINS->getCST() === '05') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcIsento($COFINS);
        } elseif ($COFINS->getCST() === '06') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcIsento($COFINS);
        } elseif ($COFINS->getCST() === '07') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcIsentoDesconto($COFINS);
        } elseif ($COFINS->getCST() === '08') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcIsento($COFINS);
        } elseif ($COFINS->getCST() === '09') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcIsento($COFINS);
        } elseif ($COFINS->getCST() === '49') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcIsento($COFINS);
        } elseif ($COFINS->getCST() === '50') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '51') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '52') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '53') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '54') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '55') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '56') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '60') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '61') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '62') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '63') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '64') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '65') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '66') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '67') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '70') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcIsento($COFINS);
        } elseif ($COFINS->getCST() === '71') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '72') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '73') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '74') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '75') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '98') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '99') {
            throw new NotImplementedCSTException($COFINS->getCST());
//            return self::calcIsento($COFINS);
        }
        throw new InvalidCSTException($COFINS->getCST());
    }

//    private static function calcIsento($COFINS)
//    {
//        $COFINS->pCOFINS = 3;
//        if ($COFINS->REIDI === 1 || $COFINS->SUFRAMA === 1) {
//            $COFINS->Desconto = $COFINS->vBC * ($COFINS->pCOFINS / 100);
//        } else {
//            $COFINS->Desconto = 0;
//        }
//        $COFINS->vCOFINS = '0';
//        $COFINS->vBC = '0';
//        $COFINS->pCOFINS = '0';
//
//        return $COFINS;
//    }

    private static function calcaCOFINS($COFINS)
    {
        $COFINS->pCOFINS = 3;
        $COFINS->pRedBC = 0;
        $COFINS->vCOFINS = (($COFINS->vBC - ($COFINS->vBC * ($COFINS->pRedBC / 100))) * ($COFINS->pCOFINS / 100));
//        if ($COFINS->REIDI === 1 || $COFINS->SUFRAMA === 1) {
//            $COFINS->Desconto = $COFINS->vBC * ($COFINS->pCOFINS / 100);
//        } else {
        $COFINS->Desconto = 0;
//        }
        return $COFINS;
    }

//    private static function calcIsentoDesconto($COFINS)
//    {
//        $COFINS->pCOFINS = 3;
//        if ($COFINS->REIDI === 1 || $COFINS->SUFRAMA === 1) {
//            $COFINS->Desconto = $COFINS->vBC * ($COFINS->pCOFINS / 100);
//        } else {
//            $COFINS->Desconto = 0;
//        }
//
//        $COFINS->pCOFINS = '0';
//        $COFINS->vBC = '0';
//        $COFINS->pCOFINS = '0';
//        $COFINS->vCOFINS = '0';
//
//        return $COFINS;
//    }
//
//    private static function calcAliqCST03($COFINS)
//    {
//        $COFINS->vBC = 0;
//        $COFINS->pCOFINS = 0;
//        $COFINS->vCOFINS = round((($COFINS->vAliqProd) * ($COFINS->qBCProd)), 2);
//        $COFINS->Desconto = 0;
//
//        return $COFINS;
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
