<?php

declare(strict_types=1);

namespace Gbbs\Impostos;

class COFINS
{
    public function __construct($COFINS, $CodCli, $CodPro)
    {
        $dummy = new \stdClass();  // TODO retrieve data from correct source

        if ($COFINS->Zerar === 1) {
            $COFINS->pCOFINS = '0';
            $COFINS->vBC = '0';
            $COFINS->pCOFINS = '0';

            return $COFINS;
        }

        $cliente = $dummy->getClienteUltimoCOFINS($CodCli, $CodPro);
        if (sizeof($cliente) > 0) {
            $COFINS->CST = $cliente[0]['CST'];
        }
        switch ($COFINS->CST) {
            /* Operação Tributável com Alíquota Básica */
            case '01':
                return $this->calcaCOFINS($COFINS);
                break;
            case '02':
                return $this->calcaCOFINS($COFINS);
                break;
            case '03':
                return $this->calcAliqCST03($COFINS);
                break;
            case '04':
                return $this->calcIsento($COFINS);
                break;
            case '05':
                return $this->calcIsento($COFINS);
                break;
            case '06':
                return $this->calcIsento($COFINS);
                break;
            case '07':
                return $this->calcIsentoDesconto($COFINS);
                break;
            case '08':
                return $this->calcIsento($COFINS);
                break;
            case '09':
                return $this->calcIsento($COFINS);
                break;
            case '49':
                return $this->calcIsento($COFINS);
                break;
            case '50':
                return $this->calcaCOFINS($COFINS);
                break;
            case '51':
                return $this->calcaCOFINS($COFINS);
                break;
            case '52':
                return $this->calcaCOFINS($COFINS);
                break;
            case '53':
                return $this->calcaCOFINS($COFINS);
                break;
            case '54':
                return $this->calcaCOFINS($COFINS);
                break;
            case '55':
                return $this->calcaCOFINS($COFINS);
                break;
            case '56':
                return $this->calcaCOFINS($COFINS);
                break;
            case '60':
                return $this->calcaCOFINS($COFINS);
                break;
            case '61':
                return $this->calcaCOFINS($COFINS);
                break;
            case '62':
                return $this->calcaCOFINS($COFINS);
                break;
            case '63':
                return $this->calcaCOFINS($COFINS);
                break;
            case '64':
                return $this->calcaCOFINS($COFINS);
                break;
            case '65':
                return $this->calcaCOFINS($COFINS);
                break;
            case '66':
                return $this->calcaCOFINS($COFINS);
                break;
            case '67':
                return $this->calcaCOFINS($COFINS);
                break;
            case '70':
                return $this->calcIsento($COFINS);
                break;
            case '71':
                return $this->calcaCOFINS($COFINS);
                break;
            case '72':
                return $this->calcaCOFINS($COFINS);
                break;
            case '73':
                return $this->calcaCOFINS($COFINS);
                break;
            case '74':
                return $this->calcaCOFINS($COFINS);
                break;
            case '75':
                return $this->calcaCOFINS($COFINS);
                break;
            case '98':
                return $this->calcaCOFINS($COFINS);
                break;
            case '99':
                return $this->calcIsento($COFINS);
                break;
        }
    }

    private function calcIsento($COFINS)
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

    private function calcaCOFINS($COFINS)
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

    private function calcIsentoDesconto($COFINS)
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

    private function calcAliqCST03($COFINS)
    {
        $COFINS->vBC = 0;
        $COFINS->pCOFINS = 0;
        $COFINS->vCOFINS = round((($COFINS->vAliqProd) * ($COFINS->qBCProd)), 2);
        $COFINS->Desconto = 0;

        return $COFINS;
    }
}
