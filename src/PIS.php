<?php

declare(strict_types=1);

namespace Gbbs\Impostos;

class PIS
{
    public function __construct($PIS, $CodCli, $CodPro)
    {
        $dummy = new \stdClass();  // TODO retrieve data from correct source


        if ($PIS->Zerar === 1) {
            $PIS->pPIS = '0';
            $PIS->vBC = '0';
            $PIS->pPIS = '0';

            return $PIS;
        }

        $cliente = $dummy->getClienteUltimoPIS($CodCli, $CodPro);
        if (sizeof($cliente) > 0) {
            $PIS->CST = $cliente[0]['CST'];
        }
        switch ($PIS->CST) {
            /* Operação Tributável com Alíquota Básica */
            case '01':
                return $this->calcaPIS($PIS);
                break;
            case '02':
                return $this->calcaPIS($PIS);
                break;
            case '03':
                return $this->calcAliqCST03($PIS);
                break;
            case '04':
                return $this->calcIsento($PIS);
                break;
            case '05':
                return $this->calcIsento($PIS);
                break;
            case '06':
                return $this->calcIsento($PIS);
                break;
            case '07':
                return $this->calcIsentoDesconto($PIS);
                break;
            case '08':
                return $this->calcIsento($PIS);
                break;
            case '09':
                return $this->calcIsento($PIS);
                break;
            case '49':
                return $this->calcIsento($PIS);
                break;
            case '50':
                return $this->calcaPIS($PIS);
                break;
            case '51':
                return $this->calcaPIS($PIS);
                break;
            case '52':
                return $this->calcaPIS($PIS);
                break;
            case '53':
                return $this->calcaPIS($PIS);
                break;
            case '54':
                return $this->calcaPIS($PIS);
                break;
            case '55':
                return $this->calcaPIS($PIS);
                break;
            case '56':
                return $this->calcaPIS($PIS);
                break;
            case '60':
                return $this->calcaPIS($PIS);
                break;
            case '61':
                return $this->calcaPIS($PIS);
                break;
            case '62':
                return $this->calcaPIS($PIS);
                break;
            case '63':
                return $this->calcaPIS($PIS);
                break;
            case '64':
                return $this->calcaPIS($PIS);
                break;
            case '65':
                return $this->calcaPIS($PIS);
                break;
            case '66':
                return $this->calcaPIS($PIS);
                break;
            case '67':
                return $this->calcaPIS($PIS);
                break;
            case '70':
                return $this->calcIsento($PIS);
                break;
            case '71':
                return $this->calcaPIS($PIS);
                break;
            case '72':
                return $this->calcaPIS($PIS);
                break;
            case '73':
                return $this->calcaPIS($PIS);
                break;
            case '74':
                return $this->calcaPIS($PIS);
                break;
            case '75':
                return $this->calcaPIS($PIS);
                break;
            case '98':
                return $this->calcaPIS($PIS);
                break;
            case '99':
                return $this->calcIsento($PIS);
                break;
            default:
                break;
        }
    }

    private function calcIsento($PIS)
    {
        //return $IPI;
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

    private function calcaPIS($PIS)
    {


        $PIS->pPIS = 0.65;
        if ($PIS->REIDE === 1 || $PIS->SUFRAMA === 1) {
            $PIS->Desconto = $PIS->vBC * ($PIS->pPIS / 100);
        } else {
            $PIS->Desconto = 0;
        }
        $PIS->pRedBC = 0;
        $PIS->vPIS = (($PIS->vBC - ($PIS->vBC * ($PIS->pRedBC / 100))) * ($PIS->pPIS / 100));
        //$PIS->Desconto = 0;
        return $PIS;
    }

    private function calcIsentoDesconto($PIS)
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

    private function calcAliqCST03($PIS)
    {
        /* if($PIS->REIDE === 1){
          $PIS->Desconto = $PIS->vBC * ($PIS->pPIS / 100);
          }else{
          $PIS->Desconto =0;
          } */
        $PIS->vBC = 0;
        $PIS->pPIS = 0;
        $PIS->vPIS = round((($PIS->vAliqProd) * ($PIS->qBCProd)), 2);
        //$PIS->Desconto =0;
        return $PIS;
    }
}
