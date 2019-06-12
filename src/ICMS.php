<?php

declare(strict_types=1);

namespace Gbbs\Impostos;

class ICMS
{
    private $ufOrig;
    private $ufDest;
    private $ufDestSig;
    private $CodNCM;
    private $CodEmi;
    private $ST = 0;
    private $CliContribuinte;

    public function __construct(
        $ICMS,
        $ufOrig,
        $ufDest,
        $CodCli,
        $CodNCM,
        $CodEmi,
        $CodPro,
        $CliContribuinte,
        $modBCST = null
    ) {
        $dao = new NotaFiscalDAO();

        //Logs::escreverNoLogObjeto($CodPro, "CodPro Calculo Impostos");

        $this->ufOrig = $ufOrig;
        $this->ufDest = $ufDest;
        $this->CodNCM = $CodNCM;
        $this->ufDestSig = $this->getufDesSig($this->ufDest);
        $this->CodEmi = $CodEmi;
        $this->CliContribuinte = $CliContribuinte;


        //ZERAR IMPOSTO CASO ELE VENHA COM A FLAG ZERAR retorna 0
        if ($ICMS->Zerar === 1) {
            $ICMS->vICMSST = 0;
            $ICMS->vBCST = 0;
            $ICMS->pMVAST = 0;
            $ICMS->pICMSST = 0;
            return $ICMS;
        }

        $cliente = $dao->getClienteUltimaAliquota($CodCli, $CodPro);

        //REDUÇÃO DO PERCENTUAL DA ALIQUOTA ICMS
        $reducao = $this->getPerICMSReducao($ufDest, $CodNCM, $CodPro);


        //PEGA O PERCENTUAL DO ICMS PELA TABELA UF X UF
        if ($reducao > 0) {
            $ICMS->pICMS = $reducao;
            $ICMS->pICMSST = $reducao;
        } else { //CASO NÃO HAJA REDUÇÃO, ELE IRÁ CALCULAR NORMALMENTE
            if (sizeof($cliente) > 0) {
                if ($ICMS->ClienteIE === "ISENTO") {
                    $ICMS->pICMS = $this->getPerICMS($this->ufOrig, $this->ufDest);
                    $ICMS->pICMSST = $this->getPerICMSST($this->ufOrig, $this->ufDest);
                } else {
                    $ICMS->pICMS = $cliente[0][pICMS];
                }
                $this->ST = $cliente[0][pICMSST];
                $ICMS->CST = $cliente[0][CST];
                $ICMS->descCST = $cliente[0][descricao];
                $ICMS->CFOP = $cliente[0][CFOP];
            } else {
                if ($ICMS->ClienteIE === "ISENTO") {
                    $ICMS->pICMS = $this->getPerICMS($this->ufOrig, $this->ufDest);
                    $ICMS->pICMSST = $this->getPerICMSST($this->ufOrig, $this->ufDest);
                } else {
                    $ICMS->pICMS = $this->getpICMS();
                    $ICMS->pICMSST = $this->getpICMSST();
                }
            }
        }

        switch ($ICMS->CST) {
            case "101":
                return $this->calcCSOSN101($ICMS);
                break;
            case "102":
                return $this->calcCSOSN102($ICMS);
                break;
            case "103":
                return $ICMS;
                break;
            case "201":
                return $this->calcCSOSN201($ICMS);
                break;
            case "202":
                return $this->calcCSOSN202($ICMS);
                break;
            case "203":
                return $this->calcCSOSN203($ICMS);
                break;
            case "300":
                return $ICMS;
                break;
            case "400":
                return $ICMS;
                break;
            case "500":
                return $this->calcCSOSN500($ICMS);
                break;
            case "900":
                return $this->calcCSOSN900($ICMS);
                break;
            case "00":
                return $this->calcCST00($ICMS);
                break;
            case "200":
                return $this->calcCST200($ICMS);
                break;
            case "10":
                return $this->calcCST10($ICMS, $modBCST);
                break;
            case "20":
                return $this->calcCST20($ICMS);
                break;
            case "30":
                return $this->calcCST30($ICMS);
                break;
            case "40":
                return $this->calcCST40($ICMS);
                break;
            case "41":
                return $this->calcCST41($ICMS);
                break;
            case "50":
                return $this->calcCST50($ICMS);
                break;
            case "51":
                return $this->calcCST51($ICMS);
                break;
            case "60":
                return $this->calcCST60($ICMS);
                break;
            case "70":
                return $this->calcCST70($ICMS);
                break;
            case "90":
//                if ($ICMS->UFST != null)
//                    return $this->calcCST90($ICMS);
//                else
                return $this->calcCST90c($ICMS, $modBCST);
                break;
        }
    }

    /*
     * @Pega o percentual de ICMS resultande do cruzamento de dados de 2 UF's
     */

    public function getPerICMS($orig, $dest)
    {
        $NotaFiscalDAO = new NotaFiscalDAO;
        if ($this->CliContribuinte === '1' && $dest === '42' && $orig === '42') {
            $pICMS = 12;
        } else {
            $pICMS = $NotaFiscalDAO->getpICMS($orig, $dest);
        }

        unset($NotaFiscalDAO);
        return $pICMS;
    }

    /*
     * @Pega o percentual de ICMS resultande do NCM e Estado de Destino
     */

    public function getPerICMSReducao($dest, $NCM, $CodPro)
    {
        $NotaFiscalDAO = new NotaFiscalDAO;
        $pICMS = $NotaFiscalDAO->getpICMSReducao($dest, $NCM, $CodPro);
        unset($NotaFiscalDAO);
        return $pICMS;
    }

    /*
     * @Pega o percentual de ICMSST resultande do cruzamento de dados de 2 UF's
     */

    private function getPerICMSST($orig, $dest)
    {

        if ($this->ST > 0) {
            return $this->ST;
        } else {
            $NotaFiscalDAO = new NotaFiscalDAO;
            $pICMS = $NotaFiscalDAO->getpICMSST($orig, $dest);
            unset($NotaFiscalDAO);
            return $pICMS;
        }
    }

    /*
     * @Pega o percentual de MVA
     */

    private function getPerMVAST($REG, $NCM)
    {
        $NotaFiscalDAO = new NotaFiscalDAO;
        // Logs::escreverNoLog($REG . $NCM. $this->ufDestSig);
        $pMVAST = $NotaFiscalDAO->getpMVAST($REG, $NCM, $this->ufDestSig, $this->CodEmi);
        unset($NotaFiscalDAO);
        return $pMVAST;
    }

    /*
     * @Pega a SIGLA do UF destino para o ICMS ST
     */

    private function getufDesSig($destino)
    {
        $NotaFiscalDAO = new NotaFiscalDAO;
        $ufDestSig = $NotaFiscalDAO->getufDesSig($destino);
        unset($NotaFiscalDAO);
        return $ufDestSig;
    }

    /*
     * @Pega o percentual de ICMSST
     */

    private function getpICMSST()
    {
        //    Logs::escreverNoLog($this->ufOrig.",". $this->ufDest, 'ESTADOS ');
        return $this->getPerICMSST($this->ufOrig, $this->ufDest);
    }

    /*
     * @Pega o percentual de ICMS
     */

    private function getpICMS()
    {
        return $this->getPerICMS($this->ufOrig, $this->ufDest);
    }

    /*
     * @Pega o percentual de MVA ST pelo NCM/Regime
     */

    private function getpMVAST($ICMS)
    {

        return $this->getPerMVAST($ICMS->regime, $this->CodNCM);
    }

    /*
     * @Calcula o Valor crÃ©dito do ICMS que pode ser aproveitado
     */

    private function calcvCredICMSSN($ICMS)
    {
        $ICMS->vCredICMSSN = ($ICMS->vBC * $ICMS->pCredSN) / 100;
        return $ICMS->vCredICMSSN;
    }

    /*
     * @Calcula o Valor do ICMS
     */

    private function calcvICMS($ICMS)
    {
        //Logs::escreverNoLogObjeto($ICMS, "ICMS CALCVICMS ");
        $ICMS->vICMS = ($ICMS->vBC * ($ICMS->pICMS / 100));
        return $ICMS->vICMS;
    }

//    private function calcvFCP($ICMS) {
//        //Logs::escreverNoLogObjeto($ICMS, "ICMS CALCVICMS ");
//        $ICMS->vFCP = ($ICMS->vBC * ($ICMS->pFCP / 100));
//        return $ICMS->vFCP;
//    }

    /*
     * @Calcula o Valor do ICMSST
     */

    private function calcvICMSST($ICMS, $modBCST = null)
    {

        // Logs::escreverNoLog($ICMS);
        //Logs::escreverNoLog($modBCST);

        if ($modBCST === '6') {
            $ICMS->vICMS = $this->calcvICMS($ICMS);
            $ICMS->vICMSST = $ICMS->vBCST * ($ICMS->pICMSST / 100) - $ICMS->vICMS;

            return $ICMS->vICMSST;
        }

        $ICMS->pMVAST = $this->getpMVAST($ICMS);

        if ($ICMS->pMVAST === '0') {
            $ICMS->vICMSST = '0';

            return $ICMS->vICMSST;
        }

        $ICMS->vICMS = $this->calcvICMS($ICMS);
        $ICMS->vBCST = $ICMS->vBCST * (1 + ($ICMS->pMVAST / 100)); ///VERIFICAR AQUI OQUE ESTÃ� ACONTECENDO
        $ICMS->vICMSST = (((($ICMS->vBCST - ($ICMS->vBCST * ((float)$ICMS->pRedBCST / 100)))) * ($ICMS->pICMSST / 100)) - $ICMS->vICMS);
        //$ICMS->vICMSST = (((($ICMS->vBCST + ($ICMS->vBCST * ($ICMS->pRedBCST / 100))) * ($ICMS->pMVAST/100)) * ($ICMS->pICMSST/100) - $ICMS->vICMS));

        return $ICMS->vICMSST;
    }

    private function calcvICMSDesonIsento($ICMS)
    {
        $icms_normal = ($ICMS->vBC * ($ICMS->pICMS / 100));
        $ICMS->vICMSDeson = $icms_normal;
        return $ICMS->vICMSDeson;
    }

    private function calcvICMSDeson($ICMS)
    {
        $icms_normal = ($ICMS->vBC * ($ICMS->pICMS / 100));
        $icms_reduzido = ($ICMS->vBC - ($ICMS->vBC * ($ICMS->pRedBC / 100))) * ($ICMS->pICMS / 100);
        $ICMS->vICMSDeson = $icms_normal - $icms_reduzido;
        return $ICMS->vICMSDeson;
    }

    /*
     * @Calcula  a reduÃ§Ã£o na base de culculo do ICMS
     */

    private function calcRedBC($ICMS)
    {
        $ICMS->vBC = $ICMS->vBC - ($ICMS->vBC * ((float)$ICMS->pRedBC / 100));
        return $ICMS->vBC;
    }

    /*
     * @Calcula  a reduÃ§Ã£o na base de culculo do ICMSST
     */

    private function calcRedBCST($ICMS)
    {
        $ICMS->vBCST = $ICMS->vBCST - ($ICMS->vBCST * ((float)$ICMS->pRedBCST / 100));
        return $ICMS->vBCST;
    }

    /* /// SIMPLES NACIONAL /// */

    private function calcCSOSN101($ICMS)
    {
        $ICMS->vCredICMSSN = $this->calcvCredICMSSN($ICMS);
        return $ICMS;
    }

    private function calcCSOSN102($ICMS)
    {
        $ICMS->vBC = null;
        $ICMS->vICMS = null;
        $ICMS->vBCST = null;
        $ICMS->vBCSTRet = null;
        $ICMS->vICMSSTRet = null;
        return $ICMS;
    }

    private function calcCSOSN201($ICMS)
    {
        $ICMS->pICMSST = $this->getpICMSST();
        $ICMS->vCredICMSSN = $this->calcvCredICMSSN($ICMS);
        $ICMS->vICMSST = ($this->calcvICMSST($ICMS));
        return $ICMS;
    }

    private function calcCSOSN202($ICMS)
    {
        $ICMS->pICMSST = $this->getpICMSST();
        $ICMS->vICMSST = ($this->calcvICMSST($ICMS));
        return $ICMS;
    }

    private function calcCSOSN203($ICMS)
    {
        $ICMS->pICMSST = $this->getpICMSST();
        $ICMS->vICMSST = ($this->calcvICMSST($ICMS));
        return $ICMS;
    }

    private function calcCSOSN500($ICMS)
    {
        $ICMS->vBC = null;
        $ICMS->vICMS = null;
        $ICMS->vBCST = null;
        $ICMS->vICMSST = null;
        return $ICMS;
    }

    private function calcCSOSN900($ICMS)
    {
        $ICMS->pICMSST = $this->getpICMSST();
        $ICMS->vCredICMSSN = $this->calcvCredICMSSN($ICMS);
        $ICMS->vICMS = ($this->calcvICMS($ICMS));
        $ICMS->vICMSST = ($this->calcvICMSST($ICMS));
        return $ICMS;
    }

    /* --- FUNCOES CALCULOS POR CST DO REGIME NORMAL --- */

    private function calcCST00($ICMS)
    {

        $ICMS->vICMS = ($this->calcvICMS($ICMS));
        //$ICMS->vFCP = ($this->calcvFCP($ICMS));
        $ICMS->vICMSST = 0;
        $ICMS->vBCST = 0;
        $ICMS->pMVAST = 0;
        $ICMS->pICMSST = 0;

        return $ICMS;
    }

    private function calcCST200($ICMS)
    {

        $ICMS->vICMS = ($this->calcvICMS($ICMS));
        //$ICMS->vICMS = "120";
        //$ICMS->pICMS = 0;
        $ICMS->vICMSST = 0;
        $ICMS->vBCST = 0;
        $ICMS->pMVAST = 0;
        $ICMS->pICMSST = 0;
        $ICMS->orig = 2;

        return $ICMS;
    }

    private function calcCST10($ICMS, $modBCST = null)
    {

        $ICMS->vBCST = $this->calcRedBCST($ICMS);
        $ICMS->vBC = $this->calcRedBC($ICMS);
        //$ICMS->pICMS = $this->getpICMS();

        //  $ICMS->pICMSST = $this->getpICMSST();
        $ICMS->vICMS = ($this->calcvICMS($ICMS));
        $ICMS->vICMSST = $this->calcvICMSST($ICMS, $modBCST);

        //Logs::escreverNoLogObjeto($ICMS, $titulo);
        return $ICMS;
    }

    private function calcCST20($ICMS)
    {
//        $ICMS->pRedBC = 0;
        $ICMS->vICMSDeson = $this->calcvICMSDeson($ICMS);
        $ICMS->vBC = $this->calcRedBC($ICMS);
        $ICMS->vICMS = ($this->calcvICMS($ICMS));


        $ICMS->vICMSST = 0;
        $ICMS->vBCST = 0;
        $ICMS->pMVAST = 0;
        $ICMS->pICMSST = 0;
        return $ICMS;
    }

    private function calcCST30($ICMS)
    {
        $ICMS->vBCST = $this->calcRedBCST($ICMS);
        $ICMS->pICMSST = $this->getpICMSST();
        $ICMS->vICMSST = ($this->calcvICMSST($ICMS));
        return $ICMS;
    }

    private function calcCST40($ICMS)
    {
        $ICMS->vICMSDeson = $this->calcvICMSDesonIsento($ICMS);
        if ($ICMS->SUFRAMA === 1) {
            $ICMS->Desconto = $ICMS->vBC * ($ICMS->pICMS / 100);
        } else {
            $ICMS->Desconto = 0;
        }


        $ICMS->vBC = 0;
        $ICMS->vICMS = 0;
        $ICMS->pICMS = 0;


        $ICMS->vICMSST = 0;
        $ICMS->vBCST = 0;
        $ICMS->pMVAST = 0;
        $ICMS->pICMSST = 0;

        return $ICMS;
    }

    private function calcCST41($ICMS)
    {
        $ICMS->vICMSDeson = $this->calcvICMSDesonIsento($ICMS);
        $ICMS->vBC = 0;
        $ICMS->vICMS = 0;
        $ICMS->pICMS = 0;


        $ICMS->vICMSST = 0;
        $ICMS->vBCST = 0;
        $ICMS->pMVAST = 0;
        $ICMS->pICMSST = 0;
        return $ICMS;
    }

    private function calcCST50($ICMS)
    {
        $ICMS->vBC = 0;
        $ICMS->vICMS = 0;
        $ICMS->pICMS = 0;


        $ICMS->vICMSST = 0;
        $ICMS->vBCST = 0;
        $ICMS->pMVAST = 0;
        $ICMS->pICMSST = 0;

        return $ICMS;
    }

    private function calcCST51($ICMS)
    {

//      <ICMS>
//      <ICMS51>
//      <orig>0</orig>
//      <CST>51</CST>
//      <modBC>3</modBC>
//      <pRedBC>20.00</pRedBC>
//      <vBC>80.00</vBC>
//      <pICMS>12.00</pICMS>
//      <vICMS>9.60</vICMS>
//      </ICMS51>
//      </ICMS>

        $ICMS->vBC = $this->calcRedBC($ICMS);
        $ICMS->pICMS = $this->getpICMS();
        $ICMS->vICMS = ($this->calcvICMS($ICMS));

        $ICMS->vICMSST = 0;
        $ICMS->vBCST = 0;
        $ICMS->pMVAST = 0;
        $ICMS->pICMSST = 0;

        return $ICMS;
    }

    private function calcCST60($ICMS)
    {

        $ICMS->vBC = 0;
        $ICMS->vICMS = 0;
        $ICMS->pICMS = 0;
        $ICMS->vICMSST = 0;
        $ICMS->vBCST = 0;
        $ICMS->pMVAST = 0;
        $ICMS->pICMSST = 0;

        return $ICMS;
    }

    private function calcCST70($ICMS)
    {

        $ICMS->vBCST = $this->calcRedBCST($ICMS);
        $ICMS->vBC = $this->calcRedBC($ICMS);
        $ICMS->pICMSST = $this->getpICMSST();
        $ICMS->vICMS = ($this->calcvICMS($ICMS));
        $ICMS->vICMSST = ($this->calcvICMSST($ICMS));

        return $ICMS;
    }

    private function calcCST90c($ICMS, $modBCST)
    {
        //  $ICMS->vICMS = ($this->calcvICMS( $ICMS ));
        if ($ICMS->CSTNotaRef === '10') {
            $ICMS->vICMS = ($this->calcvICMS($ICMS));
            $ICMS->vICMSST = $this->calcvICMSST($ICMS, $modBCST);
        } else {
            $ICMS->vICMS = ($this->calcvICMS($ICMS));
        }
        $ICMS->vICMSDeson = $this->calcvICMSDesonIsento($ICMS);
        return $ICMS;
    }
}
