<?php

declare(strict_types=1);

namespace Gbbs\Impostos;

class IPI
{
    private $CodNCM;

    public function __construct($IPI, $CodNCM, $CodCli, $CodPro)
    {
        $dao = new NotaFiscalDAO();

        $this->CodNCM = $CodNCM;
        $IPI->pIPI = $this->getpIPI();


        if ($IPI->Zerar === 1) {
            $IPI->vBC = '0';
            if ($IPI->vIPI === 0) {
                $IPI->pIPI = 0;
            }

            return $IPI;
        }


        $cliente = $dao->getClienteUltimoIPI($CodCli, $CodPro);
        if (sizeof($cliente) > 0) {
            $IPI->CST = $cliente[0]['CST'];
            $IPI->descCST = $cliente[0]['descricao'];
        }


        switch ($IPI->CST) {
            /* ENTRADA COM RECUPERAÇÃO DE CRÉDITO */
            case 00:
                return $this->calcAliquotaAdValoren($IPI);
                break;
            /* OUTRAS ENTRADAS */
            case 49:
                return $this->calcRetornoIsentoValorOutros($IPI);
                break;
            /* SAÍDA TRIBUTADA */
            case 50:
                return $this->calcAliquotaAdValoren($IPI);
                break;
            /* OUTRAS SAÍDAS */
            case 99:
                return $this->calcAliquotaAdValoren($IPI);
                break;


            /* 01 ENTRADA TRIBUTADA COM ALICOTA ZERO */
            case 01:
                return $this->calcIsento($IPI);
                break;
            /* ENTRADA ISENTA */
            case 02:
                return $this->calcIsento($IPI);
                break;
            /* ENTRADA NÃO TRIBUTADA */
            case 03:
                return $this->calcIsento($IPI);
                break;
            /* ENTRADA IMUNE */
            case 04:
                return $this->calcIsento($IPI);
                break;
            /* ENTRADA COM SUSPENSAO */
            case 05:
                return $this->calcIsento($IPI);
                break;
            /* SAÍDA TRIBUTADA COM ALICOTA ZERO */
            case 51:
                return $this->calcIsento($IPI);
                break;
            /* SAÍDA ISENTA */
            case 52:
                return $this->calcIsento($IPI);
                break;
            /* SAÍDA NÃO-TRIBUTADA */
            case 53:
                return $this->calcIsento($IPI);
                break;
            /* SAÍDA IMUNE */
            case 54:
                return $this->calcIsento($IPI);
                break;
            /* SAÍDA COM SUSPENSAO */
            case 55:
                return $this->calcIsento($IPI);
                break;
        }


        //  return $this->calcAliquotaAdValoren($IPI);
        // switch ($IPI->TipoAliquota) {
        //     case 0:
        //   break;
        //  case 1:
        //     return $this->calcAliquotaEspecifica($IPI);
        // break;
        //}
    }

    /*
     * @ISENTO
     */

    private function calcIsento($IPI)
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

    private function calcAliquotaAdValoren($IPI)
    {
        $IPI->vIPI = ($IPI->vBC * ($IPI->pIPI / 100));
        return $IPI;
    }

    private function calcRetornoIsentoValorOutros($IPI)
    {
        if ($IPI->CSTNotaRef === '00' || $IPI->CSTNotaRef === '50' || $IPI->CSTNotaRef === '99') {
            $IPI->vIPI = ($IPI->vBC * ($IPI->pIPI / 100));
            $IPI->pIPI = 0;
            return $IPI;
        } else {
            return $this->calcIsento($IPI);
        }
    }

    /*
     * @Pega o percentual de IPI
     */

    private function getpIPI()
    {
        return $this->getPerIPI($this->CodNCM);
    }

    /*
     * @Pega o percentual de IPI pelo NCM do Produto.
     */

    private function getPerIPI($CodNCM)
    {
        $NotaFiscalDAO = new NotaFiscalDAO;
        $pIPI = $NotaFiscalDAO->getpIPI($CodNCM);
        unset($NotaFiscalDAO);
        return $pIPI;
    }
}
