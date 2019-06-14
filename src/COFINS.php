<?php

declare(strict_types=1);

namespace Gbbs\NfeCalculos;

use Exception;

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
    public $REIDE;
    public $SUFRAMA;
    public $Zerar;

    /**
     * @param $COFINS
     * @return mixed
     * @throws Exception
     */
    public static function calcular(COFINS $COFINS)
    {
        if ($COFINS->Zerar === 1) {
            $COFINS->pCOFINS = '0';
            $COFINS->vBC = '0';
            $COFINS->pCOFINS = '0';

            return $COFINS;
        }

        if ($COFINS->getCST() === '01') {
            /* Operação Tributável com Alíquota Básica */
            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '02') {
            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '03') {
            return self::calcAliqCST03($COFINS);
        } elseif ($COFINS->getCST() === '04') {
            return self::calcIsento($COFINS);
        } elseif ($COFINS->getCST() === '05') {
            return self::calcIsento($COFINS);
        } elseif ($COFINS->getCST() === '06') {
            return self::calcIsento($COFINS);
        } elseif ($COFINS->getCST() === '07') {
            return self::calcIsentoDesconto($COFINS);
        } elseif ($COFINS->getCST() === '08') {
            return self::calcIsento($COFINS);
        } elseif ($COFINS->getCST() === '09') {
            return self::calcIsento($COFINS);
        } elseif ($COFINS->getCST() === '49') {
            return self::calcIsento($COFINS);
        } elseif ($COFINS->getCST() === '50') {
            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '51') {
            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '52') {
            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '53') {
            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '54') {
            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '55') {
            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '56') {
            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '60') {
            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '61') {
            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '62') {
            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '63') {
            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '64') {
            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '65') {
            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '66') {
            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '67') {
            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '70') {
            return self::calcIsento($COFINS);
        } elseif ($COFINS->getCST() === '71') {
            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '72') {
            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '73') {
            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '74') {
            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '75') {
            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '98') {
            return self::calcaCOFINS($COFINS);
        } elseif ($COFINS->getCST() === '99') {
            return self::calcIsento($COFINS);
        }
        throw new Exception('Erro ao calcular COFINS' . print_r($COFINS, true));
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
